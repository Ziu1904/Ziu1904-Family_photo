<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Hiển thị trang booking
     */
    public function index()
    {
        $packages = \App\Models\Package::where('is_active', true)->get();
        return view('booking', compact('packages'));
    }

    /**
     * Xử lý đặt lịch
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
            'members' => 'required|integer|min:1',
            'date' => 'required|date',
            'concept' => 'required|string',
            'package' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'note' => 'nullable|string',
        ]);

        try {
            // ✅ Tránh trùng lịch (basic)
            $exists = Booking::where('date', $validated['date'])
                ->where('status', '!=', 'cancelled')
                ->exists();

            if ($exists) {
                return redirect()->back()
                    ->with('error', 'Ngày này đã được đặt, vui lòng chọn ngày khác!')
                    ->withInput();
            }

            // ✅ Tạo booking
            $booking = Booking::create($validated);

            // ✅ Gửi email (có try/catch tránh crash)
            try {
                Mail::raw(
                    "📸 FamilyPhoto Studio\n\n" .
                    "Bạn đã đặt lịch thành công!\n" .
                    "📅 Ngày chụp: " . $booking->date . "\n" .
                    "📦 Gói: " . $booking->package . "\n\n" .
                    "Vui lòng thanh toán để xác nhận lịch.",
                    function ($msg) use ($booking) {
                        $msg->to($booking->email)
                            ->subject("Xác nhận đặt lịch - FamilyPhoto");
                    }
                );
            } catch (\Exception $e) {
                // không crash nếu mail lỗi
            }

            // ✅ Bỏ qua thanh toán, thông báo thành công trực tiếp
            return redirect()->route('booking')
                ->with('success', 'Đặt lịch thành công! Chúng tôi sẽ liên hệ với bạn sớm để xác nhận.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi khi lưu đặt lịch. Vui lòng thử lại sau.')
                ->withInput();
        }
    }

    /**
     * API: lấy ngày đã đặt
     */
    public function getBookedDates()
    {
        try {
            return Booking::where('status', '!=', 'cancelled')
                ->pluck('date')
                ->map(function ($date) {
                    return Carbon::parse($date)->format('Y-m-d');
                });
        } catch (\Exception $e) {
            // Trả về array rỗng nếu database chưa được setup
            return [];
        }
    }

    /**
     * Thanh toán VNPay
     */
    public function vnpay($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return redirect()->route('booking')
                ->with('error', 'Không tìm thấy lịch đặt');
        }

        // giá theo gói
        $prices = [
            'Silver' => 500000,
            'Gold' => 800000,
            'Platinum' => 1200000,
        ];

        $amount = $prices[$booking->package] ?? 500000;

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.return');
        $vnp_TmnCode = env('VNP_TMN_CODE', 'YOUR_TMN_CODE'); // Cấu hình trong .env
        $vnp_HashSecret = env('VNP_HASH_SECRET', 'YOUR_HASH_SECRET'); // Cấu hình trong .env

        $vnp_TxnRef = $booking->id . '_' . time(); // Mã đơn hàng duy nhất
        $vnp_OrderInfo = "Thanh toan booking #" . $booking->id;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $amount * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect($vnp_Url);
    }

    /**
     * Callback VNPay
     */
    public function vnpayReturn(Request $request)
    {
        // Tách booking ID ra khỏi timestamp đã nối ở trên
        $txnRef = $request->input('vnp_TxnRef');
        $bookingId = explode('_', $txnRef)[0];
        $responseCode = $request->input('vnp_ResponseCode');

        $booking = Booking::find($bookingId);

        if (!$booking) {
            return redirect()->route('booking')
                ->with('error', 'Không tìm thấy lịch đặt');
        }

        if ($responseCode == '00') {
            // ✅ thanh toán thành công
            $booking->update(['status' => 'paid']);

            return redirect()->route('booking')
                ->with('success', 'Thanh toán thành công! Lịch của bạn đã được xác nhận.');
        } else {
            // ❌ thất bại
            return redirect()->route('booking')
                ->with('error', 'Thanh toán thất bại. Vui lòng thử lại.');
        }
    }
}
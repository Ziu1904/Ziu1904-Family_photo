<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect($this->redirectPathFor(Auth::user()));
        }

        return view('auth.login');
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect($this->redirectPathFor(Auth::user()));
        }

        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user) {
            if ($this->isBcryptHash($user->password)) {
                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();

                    return redirect()->intended($this->redirectPathFor(Auth::user()));
                }

                $directHashMatch = $this->isBcryptHash($credentials['password']) && hash_equals($user->password, $credentials['password']);

                if ($directHashMatch) {
                    Auth::login($user);
                    $request->session()->regenerate();

                    return redirect()->intended($this->redirectPathFor($user));
                }
            } else {
                $plainMatch = $credentials['password'] === $user->password;

                if ($plainMatch) {
                    $user->password = Hash::make($credentials['password']);
                    $user->save();

                    Auth::login($user);
                    $request->session()->regenerate();

                    return redirect()->intended($this->redirectPathFor($user));
                }
            }
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    private function isBcryptHash(string $value): bool
    {
        return preg_match('/^\$2[aby]\$\d{2}\$[\.\/A-Za-z0-9]{53}$/', $value) === 1;
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'phone' => ['nullable', 'string', 'max:30'],
            'school' => ['nullable', 'string', 'max:255'],
            'class' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Vui lòng nhập họ tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email phải đúng định dạng và có ký tự @.',
            'email.unique' => 'Email này đã được đăng ký.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.mixed' => 'Mật khẩu phải có cả chữ hoa và chữ thường.',
            'password.numbers' => 'Mật khẩu phải có ít nhất một chữ số.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'school' => $validated['school'] ?? null,
            'class' => $validated['class'] ?? null,
            'role' => 'user',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('account')->with('success', 'Đăng ký tài khoản thành công.');
    }

    public function account()
    {
        $user = Auth::user()->load([
            'consultations' => fn ($query) => $query->latest(),
        ]);

        return view('account.index', compact('user'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'));
    }

    private function redirectPathFor(User $user): string
    {
        return in_array($user->role, ['admin', 'manager'], true)
            ? route('admin.dashboard')
            : route('account');
    }
}
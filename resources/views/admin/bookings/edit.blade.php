@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Đặt Lịch #' . $booking->id)
@section('page_title', 'Chỉnh Sửa Đặt Lịch #' . $booking->id)

@section('content')
@include('admin.bookings.create')
@endsection

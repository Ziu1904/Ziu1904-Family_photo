@extends('layouts.admin')

@section('title', 'Chỉnh Sửa Gói')
@section('page_title', 'Chỉnh Sửa Gói: ' . $package->name)

@section('content')
    @include('admin.packages.form')
@endsection

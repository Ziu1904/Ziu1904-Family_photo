@extends('layouts.admin')

@section('title', 'Edit Album')
@section('page_title', 'Edit Album: ' . ($album->name ?? ''))

@section('content')
    @include('admin.albums.create', ['album' => $album])
@endsection
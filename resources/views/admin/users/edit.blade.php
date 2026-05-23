@extends('layouts.admin')

@section('title', 'Edit User')
@section('page_title', 'Edit User: ' . $user->name)

@section('content')
<div style="background: white; border-radius: 8px; padding: 30px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); max-width: 600px;">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Name</label>
            <input type="text" name="name" class="form-control-admin" value="{{ $user->name }}" required>
            @error('name') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Email</label>
            <input type="email" name="email" class="form-control-admin" value="{{ $user->email }}" required>
            @error('email') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Phone</label>
            <input type="text" name="phone" class="form-control-admin" value="{{ $user->phone ?? '' }}">
            @error('phone') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">School</label>
            <input type="text" name="school" class="form-control-admin" value="{{ $user->school ?? '' }}">
            @error('school') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Class</label>
            <input type="text" name="class" class="form-control-admin" value="{{ $user->class ?? '' }}">
            @error('class') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Role</label>
            <select name="role" class="form-control-admin" style="width: 100%;" required>
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>Manager</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div style="text-align: right; margin-top: 30px;">
            <button type="submit" class="btn btn-primary-admin">Update User</button>
            <a href="{{ route('admin.users.index') }}" class="btn" style="background: #e9ecef; color: #333; border-radius: 6px; padding: 10px 20px; border: none; cursor: pointer; text-decoration: none; margin-left: 10px;">Cancel</a>
        </div>
    </form>
</div>
@endsection

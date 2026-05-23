@extends('layouts.admin')

@section('title', 'Create User')
@section('page_title', 'Create User')

@section('content')
<div style="background: white; border-radius: 8px; padding: 30px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); max-width: 650px;">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Name</label>
            <input type="text" name="name" class="form-control-admin" value="{{ old('name') }}" required>
            @error('name') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Email</label>
            <input type="email" name="email" class="form-control-admin" value="{{ old('email') }}" maxlength="255" placeholder="name@example.com" required>
            <small style="color: #666;">Email must contain @ and use a valid email format.</small>
            @error('email') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Phone</label>
            <input type="text" name="phone" class="form-control-admin" value="{{ old('phone') }}">
            @error('phone') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">School</label>
            <input type="text" name="school" class="form-control-admin" value="{{ old('school') }}">
            @error('school') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Class</label>
            <input type="text" name="class" class="form-control-admin" value="{{ old('class') }}">
            @error('class') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Role</label>
            <select name="role" class="form-control-admin" style="width: 100%;" required>
                <option value="user" {{ old('role', 'user') === 'user' ? 'selected' : '' }}>User</option>
                <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>Manager</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Password</label>
            <input
                type="password"
                name="password"
                class="form-control-admin"
                minlength="8"
                pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}"
                title="Password must be at least 8 characters and include uppercase, lowercase, and a number."
                required
            >
            <small style="color: #666;">At least 8 characters, including uppercase, lowercase, and a number.</small>
            @error('password') <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control-admin" minlength="8" required>
        </div>

        <div style="text-align: right; margin-top: 30px;">
            <button type="submit" class="btn btn-primary-admin">Create User</button>
            <a href="{{ route('admin.users.index') }}" class="btn" style="background: #e9ecef; color: #333; border-radius: 6px; padding: 10px 20px; border: none; cursor: pointer; text-decoration: none; margin-left: 10px;">Cancel</a>
        </div>
    </form>
</div>
@endsection

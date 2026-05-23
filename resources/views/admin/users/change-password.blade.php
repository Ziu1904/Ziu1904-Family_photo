@extends('layouts.admin')

@section('title', 'Change Password')
@section('page_title', 'Change Password for: ' . $user->name)

@section('content')
<div style="background: white; border-radius: 8px; padding: 30px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); max-width: 600px;">
    @if($errors->any())
        <div style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
            <strong>Errors:</strong>
            <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update-password', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <h5 style="margin-bottom: 25px; font-weight: 600; color: #333;">User: {{ $user->name }}</h5>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Current Password</label>
            <input type="password" name="current_password" class="form-control-admin @error('current_password') is-invalid @enderror" required>
            @error('current_password')
                <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">New Password</label>
            <input type="password" name="password" class="form-control-admin @error('password') is-invalid @enderror" required>
            <small style="color: #666; display: block; margin-top: 5px;">
                Password must be at least 8 characters with uppercase, lowercase, and numbers
            </small>
            @error('password')
                <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="color: #333; font-weight: 600;">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control-admin @error('password_confirmation') is-invalid @enderror" required>
            @error('password_confirmation')
                <span style="color: #dc3545; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="text-align: right; margin-top: 30px;">
            <button type="submit" class="btn btn-primary-admin">Change Password</button>
            <a href="{{ route('admin.users.show', $user->id) }}" class="btn" style="background: #e9ecef; color: #333; border-radius: 6px; padding: 10px 20px; border: none; cursor: pointer; text-decoration: none; margin-left: 10px;">Cancel</a>
        </div>
    </form>
</div>

<script>
    // Real-time password strength validation
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.querySelector('input[name="password"]');
        
        if(passwordInput) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                const hasUpperCase = /[A-Z]/.test(password);
                const hasLowerCase = /[a-z]/.test(password);
                const hasNumbers = /[0-9]/.test(password);
                const isLongEnough = password.length >= 8;
                
                if(!isLongEnough || !hasUpperCase || !hasLowerCase || !hasNumbers) {
                    this.style.borderColor = '#dc3545';
                } else {
                    this.style.borderColor = '#28a745';
                }
            });
        }
    });
</script>
@endsection

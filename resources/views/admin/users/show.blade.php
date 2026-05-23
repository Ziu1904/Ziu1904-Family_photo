@extends('layouts.admin')

@section('title', 'User: ' . $user->name)
@section('page_title', 'User: ' . $user->name)

@section('content')
<div style="background: white; border-radius: 8px; padding: 30px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);">
    <div class="row">
        <div class="col-md-8">
            <h5 style="margin-bottom: 20px; font-weight: 600; color: #333;">User Information</h5>
            
            <div style="margin-bottom: 20px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Name</label>
                <div style="color: #333; font-size: 16px; font-weight: 600;">{{ $user->name }}</div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Email</label>
                <div style="color: #333; font-size: 16px;">{{ $user->email }}</div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Phone</label>
                <div style="color: #333; font-size: 16px;">{{ $user->phone ?? 'Not provided' }}</div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">School</label>
                <div style="color: #333; font-size: 16px;">{{ $user->school ?? 'Not provided' }}</div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Class</label>
                <div style="color: #333; font-size: 16px;">{{ $user->class ?? 'Not provided' }}</div>
            </div>
        </div>

        <div class="col-md-4">
            <h5 style="margin-bottom: 20px; font-weight: 600; color: #333;">Account Information</h5>
            
            <div style="background: #f8f9fa; padding: 20px; border-radius: 6px; margin-bottom: 20px;">
                <div style="margin-bottom: 15px;">
                    <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Role</label>
                    <div style="color: #333; font-size: 16px;">
                        <span class="badge" style="background: {{ $user->role === 'admin' ? '#667eea' : ($user->role === 'manager' ? '#17a2b8' : '#28a745') }}; color: white;">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="color: #999; font-size: 12px; text-transform: uppercase; font-weight: 600;">Member Since</label>
                    <div style="color: #333; font-size: 16px;">{{ optional($user->created_at)->format('M d, Y') ?? 'N/A' }}</div>
                </div>

                </div>
            </div>
        </div>
    </div>

    <div style="margin-top: 30px; text-align: right;">
        <a href="{{ route('admin.users.change-password', $user->id) }}" class="btn btn-warning" style="background: #ffc107; color: #333; border-radius: 6px; padding: 10px 20px; border: none; cursor: pointer; text-decoration: none; display: inline-block; margin-right: 10px;">Change Password</a>
        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary-admin" style="display: inline-block; margin-right: 10px;">Edit</a>
        <a href="{{ route('admin.users.index') }}" class="btn" style="background: #e9ecef; color: #333; border-radius: 6px; padding: 10px 20px; border: none; cursor: pointer; text-decoration: none; display: inline-block;">Back</a>
    </div>
</div>
@endsection

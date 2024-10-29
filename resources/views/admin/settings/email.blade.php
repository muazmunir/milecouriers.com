@extends('layouts.admin')
@section('content')
<div class="container mt-5">
    <h2>Update Email Settings</h2>
    <div class="card">
        <div class="card-header">
            <h5>Configure Email Settings</h5>
        </div>
        <div class="card-body">
        @if (session('success') || session('message'))
         <div class="alert alert-{{ session('alert-type', 'success') }} alert-dismissible fade show" role="alert">
            {{ session('success') ?? session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
         @endif
            <form id="emailSettingForm" method="POST" action="{{ route('email-settings.update') }}">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="driver" class="form-label">Driver</label>
                    <select class="form-select" id="driver" name="driver" required>
                        <option value="" disabled selected>-- Select Driver --</option>
                        <option value="smtp" {{ old('driver', $emailSetting->driver) == 'smtp' ? 'selected' : '' }}>SMTP</option>
                        <option value="sendmail" {{ old('driver', $emailSetting->driver) == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                        <option value="mailgun" {{ old('driver', $emailSetting->driver) == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                        <option value="postmark" {{ old('driver', $emailSetting->driver) == 'postmark' ? 'selected' : '' }}>Postmark</option>
                        <option value="ses" {{ old('driver', $emailSetting->driver) == 'ses' ? 'selected' : '' }}>Amazon SES</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>

                <div class="mb-3">
                    <label for="host" class="form-label">Host</label>
                    <input type="text" class="form-control" id="host" name="host" value="{{ old('host', $emailSetting->host) }}" required>
                </div>

                <div class="mb-3">
                    <label for="port" class="form-label">Port</label>
                    <input type="number" class="form-control" id="port" name="port" value="{{ old('port', $emailSetting->port) }}" required>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $emailSetting->username) }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
                </div>

                <div class="mb-3">
                    <label for="encryption" class="form-label">Encryption</label>
                    <select class="form-select" id="encryption" name="encryption" required>
                        <option value="tls" {{ old('encryption', $emailSetting->encryption) == 'tls' ? 'selected' : '' }}>TLS</option>
                        <option value="ssl" {{ old('encryption', $emailSetting->encryption) == 'ssl' ? 'selected' : '' }}>SSL</option>
                        <option value="" {{ old('encryption', $emailSetting->encryption) == '' ? 'selected' : '' }}>None</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="sender_email" class="form-label">Sender Email</label>
                    <input type="email" class="form-control" id="sender_email" name="sender_email" value="{{ old('sender_email', $emailSetting->sender_email) }}" required>
                </div>

                <div class="mb-3">
                    <label for="sender_name" class="form-label">Sender Name</label>
                    <input type="text" class="form-control" id="sender_name" name="sender_name" value="{{ old('sender_name', $emailSetting->sender_name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="reply_email" class="form-label">Reply Email</label>
                    <input type="email" class="form-control" id="reply_email" name="reply_email" value="{{ old('reply_email', $emailSetting->reply_email) }}" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="1" {{ old('status', $emailSetting->status) == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $emailSetting->status) == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Settings</button>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')
@section('content')
<div class="container mt-5">
   <!-- General Settings Card -->
   <div class="card mb-4">
      <div class="card-header">
         <h5>General Settings</h5>
      </div>
      <div class="card-body">
      @if (session('success') || session('message'))
         <div class="alert alert-{{ session('alert-type', 'success') }} alert-dismissible fade show" role="alert">
            {{ session('success') ?? session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
         @endif
         <form id="generalSettingsForm" method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Site Name -->
            <div class="form-group mb-3">
               <label for="site_name">Site Name</label>
               <input type="text" class="form-control" id="site_name" name="site_name" value="{{ $settings['site_name'] ?? '' }}" placeholder="Enter site name" required>
            </div>
            <!-- Site Logo -->
            <div class="form-group mb-3">
               <label for="logo">Site Logo</label>
               <input type="file" class="form-control" id="logo" name="logo" accept="image/*" onchange="previewImage(event, 'logoPreview')">
               <div class="mt-2">
                  <!-- Show the logo preview if it exists -->
                  @if(isset($settings['logo']))
                        <img id="logoPreview" src="/uploads/logos/{{ $settings['logo'] }}" alt="Site Logo Preview" style="max-width: 200px; max-height: 100px;">
                  @else
                        <img id="logoPreview" src="" alt="Site Logo Preview" style="display: none; max-width: 200px; max-height: 100px;">
                  @endif
               </div>
            </div>

            <!-- Favicon -->
            <div class="form-group mb-3">
               <label for="favicon">Favicon</label>
               <input type="file" class="form-control" id="favicon" name="favicon" accept="image/*" onchange="previewImage(event, 'faviconPreview')">
               <div class="mt-2">
                  <!-- Show the favicon preview if it exists -->
                  @if(isset($settings['favicon']))
                        <img id="faviconPreview" src="/uploads/favicons/{{ $settings['favicon'] }}" alt="Favicon Preview" style="max-width: 50px; max-height: 50px;">
                  @else
                        <img id="faviconPreview" src="" alt="Favicon Preview" style="display: none; max-width: 50px; max-height: 50px;">
                  @endif
               </div>
            </div>

            <!-- Contact Number -->
            <div class="form-group mb-3">
               <label for="contact_number">Contact Number</label>
               <input type="tel" class="form-control" id="contact_number" name="contact_number" value="{{ $settings['contact_number'] ?? '' }}" placeholder="Enter contact number" required>
            </div>
            <!-- Support Email -->
            <div class="form-group mb-3">
               <label for="support_email">Support Email</label>
               <input type="email" class="form-control" id="support_email" name="support_email" value="{{ $settings['support_email'] ?? '' }}" placeholder="Enter support email" required>
            </div>
            <!-- Address -->
            <div class="form-group mb-3">
               <label for="address">Address</label>
               <textarea class="form-control" id="address" name="address" rows="2" placeholder="Enter site address">{{ $settings['address'] ?? '' }}</textarea>
            </div>
            <!-- Footer Text -->
            <div class="form-group mb-3">
               <label for="footer_text">Footer Text</label>
               <textarea class="form-control" id="footer_text" name="footer_text" rows="3" placeholder="Enter footer text">{{ $settings['footer_text'] ?? '' }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save General Settings</button>
         </form>
      </div>
   </div>
   <!-- Social Media Links Card -->
   <div class="card mb-4">
      <div class="card-header">
         <h5>Social Media Links</h5>
      </div>
      <div class="card-body">
         @if (session('socialLinks') || session('message'))
         <div class="alert alert-{{ session('alert-type', 'success') }} alert-dismissible fade show" role="alert">
            {{ session('socialLinks') ?? session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
         @endif
         <form id="socialMediaForm" method="POST" action="{{ route('settings.updateSocialLinks') }}">
            @csrf
            <!-- Facebook URL -->
            <div class="form-group mb-3">
               <label for="facebook_url">Facebook URL</label>
               <input type="url" class="form-control" id="facebook_url" value="{{ $settings['facebook_url'] ?? '' }}" name="facebook_url" placeholder="https://facebook.com/yourpage">
            </div>
            <!-- Twitter URL -->
            <div class="form-group mb-3">
               <label for="twitter_url">Twitter URL</label>
               <input type="url" class="form-control" id="twitter_url" value="{{ $settings['twitter_url'] ?? '' }}" name="twitter_url" placeholder="https://twitter.com/yourprofile">
            </div>
            <!-- Instagram URL -->
            <div class="form-group mb-3">
               <label for="instagram_url">Instagram URL</label>
               <input type="url" class="form-control" id="instagram_url" value="{{ $settings['instagram_url'] ?? '' }}" name="instagram_url" placeholder="https://instagram.com/yourprofile">
            </div>
            <!-- LinkedIn URL -->
            <div class="form-group mb-3">
               <label for="linkedin_url">LinkedIn URL</label>
               <input type="url" class="form-control" id="linkedin_url" value="{{ $settings['linkedin_url'] ?? '' }}" name="linkedin_url" placeholder="https://linkedin.com/in/yourprofile">
            </div>
            <button type="submit" class="btn btn-primary">Save Social Links</button>
         </form>
      </div>
   </div>
   <!-- Google Analytics Settings Card -->
   <div class="card mb-4">
      <div class="card-header">
         <h5>Google Analytics Settings</h5>
      </div>
      <div class="card-body">
         @if (session('analytics') || session('message'))
         <div class="alert alert-{{ session('alert-type', 'success') }} alert-dismissible fade show" role="alert">
            {{ session('analytics') ?? session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
         @endif
         <form id="analyticsSettingsForm" method="POST" action="{{ route('settings.updateAnalytics') }}">
            @csrf
            <!-- Google Analytics Tracking ID -->
            <div class="form-group mb-3">
               <label for="ga_tracking_id">Google Analytics Tracking ID</label>
               <input type="text" class="form-control" id="ga_tracking_id" value="{{ $settings['ga_tracking_id'] ?? '' }}" name="ga_tracking_id" placeholder="UA-XXXXXXXXX-X">
            </div>
            <!-- Enable Analytics -->
            <div class="form-group mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="enable_analytics" name="enable_analytics" <?php echo isset($settings['enable_analytics']) && $settings['enable_analytics'] ? 'checked' : '' ?>>
    <label class="form-check-label" for="enable_analytics">Enable Google Analytics</label>
</div>
            <button type="submit" class="btn btn-primary">Save Analytics Settings</button>
         </form>
      </div>
   </div>
</div>
@endsection
@push('scripts')
<script>
   function previewImage(event, previewId) {
       const input = event.target;
       const preview = document.getElementById(previewId);
       
       if (input.files && input.files[0]) {
           const reader = new FileReader();
           reader.onload = function(e) {
               preview.src = e.target.result;
               preview.style.display = 'block';
           };
           reader.readAsDataURL(input.files[0]);
       } else {
           preview.style.display = 'none';
       }
   }
</script>
@endpush
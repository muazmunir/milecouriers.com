@extends('layouts.admin')
@section('title', $pageTitle)
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $pageTitle }}</h4>
                </div>
                <div class="card-body">
                    @if (session('success') || session('message'))
                        <div class="alert alert-{{ session('alert-type', 'success') }} alert-dismissible fade show" role="alert">
                            {{ session('success') ?? session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form class="row g-3" method="POST" action="{{ $user ? route('users.update', $user->id) : route('users.store') }}">
                        @csrf
                        @if($user)
                            @method('PUT') <!-- Use PUT for updates -->
                        @endif

                        <!-- First Name -->
                        <div class="col-md-4">
                            <label class="form-label" for="first_name">First Name</label>
                            <input class="form-control @error('first_name') is-invalid @enderror" type="text" name="first_name" placeholder="Enter first name" value="{{ old('first_name', $user ? $user->first_name : '') }}">
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-4">
                            <label class="form-label" for="last_name">Last Name</label>
                            <input class="form-control @error('last_name') is-invalid @enderror" type="text" name="last_name" placeholder="Enter last name" value="{{ old('last_name', $user ? $user->last_name : '') }}">
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        <!-- Email -->
                        <div class="col-md-4">
                            <label class="form-label" for="email">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" placeholder="Enter email" value="{{ old('email', $user ? $user->email : '') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="col-md-4">
                            <label class="form-label" for="password">Password</label>
                            <input class="form-control @error('password') is-invalid @enderror" 
                                type="password" 
                                name="password" 
                                placeholder="Enter password" 
                                autocomplete="new-password"
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div class="col-md-4">
                            <label class="form-label" for="password_confirmation">Re-enter Password</label>
                            <input class="form-control @error('password_confirmation') is-invalid @enderror" 
                                type="password" 
                                name="password_confirmation" 
                                placeholder="Re-enter password" 
                                autocomplete="new-password"
                            >
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="type">Type</label>
                            <select name="type" class="form-select" id="userType">
                            <option value="0" {{ $user && $user->type === 'user' ? 'selected' : '' }}>User</option>
                            <option value="1" {{ $user && $user->type === 'admin' ? 'selected' : '' }}>Staff</option>
                            </select>
                        </div>

                         

                        <!-- Country -->
                        <div class="col-md-4">
                            <label class="form-label" for="country_id">Country</label>
                            <select class="form-select @error('country_id') is-invalid @enderror select2" name="country_id" id="country_id">
                                <option value="" selected disabled>Choose country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ $user && $user->country_id == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('country_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- State -->
                        <div class="col-md-4">
                            <label class="form-label" for="state_id">State</label>
                            <select class="form-select @error('state_id') is-invalid @enderror" name="state_id" id="state_id" disabled>
                                <option value="" selected disabled>Choose state</option>
                                <!-- Options will be loaded dynamically -->
                            </select>
                            @error('state_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- City -->
                        <div class="col-md-4">
                            <label class="form-label" for="city">City</label>
                            <select class="form-select @error('city_id') is-invalid @enderror" name="city_id" id="city_id" disabled>
                                <option value="" selected disabled>Choose state</option>
                                <!-- Options will be loaded dynamically -->
                            </select>
                            @error('city_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        

                        <!-- Zipcode -->
                        <div class="col-md-4">
                            <label class="form-label" for="zipcode">Zipcode</label>
                            <input class="form-control @error('zipcode') is-invalid @enderror" type="text" name="zipcode" placeholder="Enter zipcode" value="{{ old('zipcode', $user ? $user->zipcode : '') }}">
                            @error('zipcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="col-md-8">
                            <label class="form-label" for="address">Address</label>
                            <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" placeholder="Enter address" value="{{ old('address', $user ? $user->address : '') }}">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">{{ $user ? 'Update' : 'Submit' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>

     
    $(document).ready(function() {
    let selectedCountryId = "{{ old('country_id', $user ? $user->country_id : '') }}";
    let selectedStateId = "{{ old('state_id', $user ? $user->state_id : '') }}";
    let selectedCityId = "{{ old('city_id', $user ? $user->city_id : '') }}";
    let isPageLoad = true; // Flag to track if it's a page load

    // Auto-select states and cities if user is being edited
    if (selectedCountryId) {
        loadStates(selectedCountryId, selectedStateId, selectedCityId);
    }

    // Handle country change event
    $('#country_id').on('change', function() {
        let countryId = $(this).val();
        loadStates(countryId);
    });

    // Handle state change event, but only after page load is complete
    $('#state_id').on('change', function() {
        if (!isPageLoad) {
            let stateId = $(this).val();
            loadCities(stateId); // Reload cities if the state is changed by the user
        }
    });

    // Load states based on country, and then load cities after states are loaded
    function loadStates(countryId, selectedState = null, selectedCity = null) {
        if (countryId) {
            $.ajax({
                url: '{{ route("get.states", "") }}/' + countryId,
                type: 'GET',
                success: function(data) {
                    $('#state_id').empty().append('<option value="" selected disabled>Choose state</option>');
                    $.each(data, function(id, name) {
                        let selected = id == selectedState ? 'selected' : '';
                        $('#state_id').append('<option value="' + id + '" ' + selected + '>' + name + '</option>');
                    });

                    $('#state_id').prop('disabled', false); // Enable state dropdown

                    // If a state is pre-selected, load cities after states are loaded
                    if (selectedState) {
                        loadCities(selectedState, selectedCity);
                    }
                },
                error: function() {
                    alert('Error retrieving states.');
                },
                complete: function() {
                    isPageLoad = false; // Once states and cities are loaded, allow future change events
                }
            });
        } else {
            $('#state_id').empty().append('<option value="" selected disabled>Choose state</option>').prop('disabled', true);
            $('#city_id').empty().append('<option value="" selected disabled>Choose city</option>').prop('disabled', true);
        }
    }

    // Load cities based on state
    function loadCities(stateId, selectedCity = null) {
        if (stateId) {
            $.ajax({
                url: '{{ route("get.cities", "") }}/' + stateId,
                type: 'GET',
                success: function(data) {
                    $('#city_id').empty().append('<option value="" selected disabled>Choose city</option>');
                    $.each(data, function(id, name) {
                        let selected = id == selectedCity ? 'selected' : '';
                        $('#city_id').append('<option value="' + id + '" ' + selected + '>' + name + '</option>');
                    });

                    $('#city_id').prop('disabled', false); // Enable city dropdown
                },
                error: function() {
                    alert('Error retrieving cities.');
                }
            });
        } else {
            $('#city_id').empty().append('<option value="" selected disabled>Choose city</option>').prop('disabled', true);
        }
    }
});

</script>
@endpush
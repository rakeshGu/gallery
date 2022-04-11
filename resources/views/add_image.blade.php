@extends('layouts.layout')
@section('title','Add')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center m-5">Add New Image</h2>
        </div>
        <div class="col-md-12">
            @if (count($errors) > 0)
                <div class = "alert alert-danger">
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif
            <div id="errorLocation"></div>
            <form method="POST" action="{{route('images.store')}}" id="addMediaForm" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="user_name" class="form-label">User name</label>
                    <input type="text" class="form-control" id="user_name" name="user_name">
                    
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image" aria-describedby="imageHelp">
                    
                    <div id="imageHelp" class="form-text">Image should be JPG/PNG/JPEG.</div>
                </div>
                
                <input type="hidden" id="lat" name="lat" value="">
                <input type="hidden" id="lon" name="lon" value="">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
    var x=document.getElementById("errorLocation");
    function getLocation(){
        if (navigator.geolocation){
            navigator.geolocation.getCurrentPosition(showPosition,showError);
        }
        else{
            x.innerHTML="Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position){
        lat=position.coords.latitude;
        lon=position.coords.longitude;
        document.getElementById("lat").value=lat;
        document.getElementById("lon").value=lon;
        console.log(lat);
        console.log(lon); 
    }
    getLocation();
    function showError(error){
        switch(error.code){
            case error.PERMISSION_DENIED:
                x.innerHTML="User denied the request for Geolocation."
            break;
            case error.POSITION_UNAVAILABLE:
                x.innerHTML="Location information is unavailable."
            break;
            case error.TIMEOUT:
                x.innerHTML="The request to get user location timed out."
            break;
            case error.UNKNOWN_ERROR:
                x.innerHTML="An unknown error occurred."
            break;
        }
    }
</script>

@extends('layouts.layout')
@section('title','Gallery View')
@section('content') 
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <h2 class="text-center m-5">List view images</h2>
        </div>
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Image Name</th>
                        <th scope="col">Height</th>
                        <th scope="col">Width</th>
                        <th scope="col">Size</th>
                        <th scope="col">Extension</th>
                        <th scope="col">Image</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($images as $image)
                    <tr>
                        <th scope="row">{{ $counter++ }}</th>
                        <td>{{$image->user_name}}</td>
                        <td>{{$image->image}}</td>
                        <td>{{$image->height}}px</td>
                        <td>{{$image->width}}px</td>
                        <td>{{round(($image->size)/1024,2)}} KB</td>
                        <td>{{$image->extension}}</td>
                        <td>
                            <a href="{{url($image->image_path)}}" target="_blank">
                                <img src="{{url($image->image_path)}}" class="thumb-image" alt="">
                            </a>
                        </td>
                        <td>{{date('d M, Y H:i:s', strtotime($image->created_at))}}</td>
                        <td>
                            <a href="{{route('images.map',$image->id)}}" >
                                View in map
                            </a>
                        </td>
                    </tr>
                    @endforeach
                   
                </tbody>
            </table>
            {{ $images->links() }}
        </div>
    </div>
</div>
@endsection
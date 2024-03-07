@extends('layouts.master')

@section('content')
    <div class="mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Albums</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>

        @include('messages.message')



        <form method="POST" action="{{ route('album.update', ['album' => $album->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="albumname" class="form-label">Name</label>
                <input value="{{ $album->name }}" name="album_name" type="text" class="form-control" id="albumname"
                    placeholder="Type Album Name">
                @if ($errors->has('album_name'))
                    <div class="alert alert-danger">
                        {{ $errors->first('album_name') }}
                    </div>
                @endif
            </div>

            <div class="input-group mb-3 border p-3">
                <button class="btn btn-outline-secondary plus-btn" type="button">+</button>
                <button class="btn btn-outline-secondary minus-btn" type="button">-</button>

                @if ($album->images->isNotEmpty())
                    @foreach ($album->images as $image)
                        <div class="col-md-12 mt-4" id="images">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Image </label>
                                    <input name="image[]" type="file" class="form-control">
                                    <p class="mt-2"> <img src="{{ asset('albums/images/' . $image->image) }}"
                                            alt="Album Image" width="100px"> </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Image Name</label>
                                    <input name="image_name[]" type="text" class="form-control"
                                        placeholder="Type Album Name" value="{{ $image->name }}">
                                </div>
                                <input type="hidden" name="image_id[]" value="{{ $image->id }}">
                            </div>
                        </div>
                    @endforeach
                @endif


            </div>

            <div class="col-auto mt-5">
                <button type="submit" class="btn btn-primary mb-3">Edit</button>
            </div>

        </form>
    </div>
@endsection
@section('js')

    <script>
        $(document).ready(function() {

            // Event listener for plus button
            $('.plus-btn').click(function(e) {
                e.preventDefault();
                const inputGroup = $(`<div class="row">
                    <div class="col-md-6">
                        <label  class="form-label">Image </label>
                        <input name="image[]" type="file" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Image Name</label>
                        <input name="image_name[]" type="text" class="form-control"  placeholder="Type Album Name">
                    </div>
                </div>`);


                $('#images').append(inputGroup);

            });



            // minus 
            $('.minus-btn').click(function() {
                if ($("#images").children().length > 1) {
                    $("#images").children().last().remove();
                }

            });
        });
    </script>
@endsection

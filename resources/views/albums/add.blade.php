@extends('layouts.master')

@section('content')
    <div class="mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Albums</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </nav>


        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif



        <form method="POST" action="{{ route('album.store') }}" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="mb-3">
                <label for="albumname" class="form-label">Name</label>
                <input value="{{ old('album_name') }}" name="album_name" type="text" class="form-control" id="albumname"
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

                <div class="col-md-12 mt-4" id="images">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Image </label>
                            <input name="image[]" type="file" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Image Name</label>
                            <input name="image_name[]" type="text" class="form-control" placeholder="Type Album Name">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-auto mt-5">
                <button type="submit" class="btn btn-primary mb-3">Submit</button>
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

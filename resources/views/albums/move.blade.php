@extends('layouts.master')

@section('content')
    <div class="mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Albums</a></li>
                <li class="breadcrumb-item active" aria-current="page">move {{ $albumDtails->name }}</li>
            </ol>
        </nav>
        @include('messages.message')
        <form method="POST" action="{{ route('album.move_update') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ $albumDtails->id }}" name="album_from" />

            <select name="album_to" class="form-select form-select-lg mb-3" aria-label="Large select example">
                <option selected value="">Select Album</option>
                @foreach ($albums as $album)
                @endforeach
                <option value="{{ $album->id }}">{{ $album->name }}</option>

            </select>


            <div class="col-auto mt-5">
                <button type="submit" class="btn btn-primary mb-3">Move</button>
            </div>

        </form>

    </div>
@endsection

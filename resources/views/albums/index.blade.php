@extends('layouts.master')

@section('content')
    <div class="mt-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Albums</a></li>
                <li class="breadcrumb-item active" aria-current="page">Home</li>
            </ol>
        </nav>

        @include('messages.message')
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Images</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($albums as $album)
                    <tr>
                        <th scope="row">{{ $album->id }}</th>
                        <td>{{ $album->name }}</td>
                        <td>
                            @foreach ($album->images as $image)
                                <span> <img src="{{ asset('albums/images/' . $image->image) }}" alt="Album Image"
                                        width="50px"> </span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('album.edit', ['album' => $album->id]) }}">
                                <button class="btn btn-primary">Edit</button>
                            </a>
                            <span>
                                <form style="display: inline" method="POST"
                                    action="{{ route('album.destroy', ['album' => $album->id]) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this album?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            </span>

                            <a href="{{ route('album.move', ['album' => $album->id]) }}">
                                <button class="btn btn-success">Move Picture </button>
                            </a>

                        </td>
                    </tr>
                @endforeach



            </tbody>
        </table>

        {{ $albums->links() }}
    </div>
@endsection


@extends('layouts.dashboard')

@section('page-title')
Urls <small><a href="{{ route('urls.create') }}" class="btn btn-sm btn-outline-primary">Create</a></small>
@endsection

@section('content')

<x-flash-message />

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>url</th>
                <th>code</th>
                <th>views</th>
                <th>Created At</th>
                <th>Action</th>
                <th>Added By</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($urls as $url)
            <tr>
                <td>{{ $url->id }}</td>
                <td><a href="{{ route('urls.show', ['url' => $url->id]) }}">{{ $url->url }}</a></td>
                <td><a href="{{ route('showUrl',$url->code)}}">Link</a> </td>
                <td>{{ $url->views }}</td>
                <td>{{ $url->created_at }}</td>
                <td><a href="{{ route('urls.edit', [$url->id]) }}" class="btn btn-sm btn-dark">Edit</a>
                    <br>
                    <form action="{{ route('urls.destroy', $url->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
                <td>
                    {{$url->findUser->name}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $urls->withQueryString()->appends(['q' => 'test'])->links() }}

@endsection
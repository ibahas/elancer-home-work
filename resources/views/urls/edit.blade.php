@extends('layouts.dashboard')

@section('page-title', 'Edit Urls')

@section('content')

        <form action="{{ route('urls.update', $url->id) }}" method="post">
            @csrf
            @method('put')
            
            @include('urls._form')
        </form>

@endsection
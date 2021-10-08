@extends('layouts.dashboard')

@section('page-title', 'Create Urls')

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $message)
        <li>{{ $message }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('urls.store') }}" method="post">
    @csrf

    @include('urls._form')
</form>

@endsection
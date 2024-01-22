@extends('layouts.layout')

@section('content')
    @if ($auth_data != Null)
        <h1>Hello World! API Key Stored</h1>
        <p>API Key = {{ $auth_data['auth_token'] }}</p>
        <p>Role = {{ $auth_data['role'] }}</p>
        <p>Id = {{ $auth_data['user_id'] }}</p>
    @endif
@endsection
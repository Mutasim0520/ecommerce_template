@extends('layouts.user.layout')
@section('title')
    <title>Contact Us</title>
@endsection

@section('content')
    <div class="single">
        <div class="container">
            <div class="col-md-12 user-box">
                Feel free to call us on {{$info->company_contact}}.
            </div>
        </div>
    </div>


@endsection
@section('scripts')
@endsection
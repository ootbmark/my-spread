@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('auth.components._verify_content')
        </div>
    </div>
</div>
@endsection

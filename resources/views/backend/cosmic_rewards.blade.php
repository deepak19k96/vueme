@extends('layouts.app-dashboard')

@section('content')

<div class="container container-gray-area p-0 bgCosmic">
    <p-cosmic-rewards :user="{{Auth::user()}}">
    </p-cosmic-rewards>
</div>

@endsection
@extends('layouts.app')

@section('content')

<div class="container text-center mt-5">
    <img src="{{ env('APP_URL') }}/images/site-images/404.png" class="img-fluid mt-5" alt="Responsive image">
</div>
<div class="container text-center mt-5">
    <a href='/'>
        <v-btn rounded color="primary" dark>Browse Gallery</v-btn>
    </a>
</div>

</div>
@endsection
@extends('layouts.app')
@section('metas')
@parent
<meta name="description" content="{{$profile_bio}}">
<link rel="canonical" href="https://www.psychics1on1.com/{{$profile_link}}">
@endsection
@section('title', $profile_name . ' | ')
@section('content')

<specialtie-profile :browser-allow="{{json_encode($browserAllow)}}" :user-id="{{$id}}" :current-user="{{ $current_user }}" :current-user-role="{{ $current_user_role }}" :current-user-appointment-count="{{ $current_user_appointment_count }}" :current-user-timezone="'{{ $current_user_timezone }}'" :timezones="{{json_encode($timezones)}}" :review-lunch="'{{ $review }}'" :browser="'{{$browser}}'" />


@endsection
@extends('layouts.app-dashboard')

@section('content')
    <user-services></user-services>

    <user-schedule :timezones="{{json_encode($timezones)}}"></user-schedule>
@endsection

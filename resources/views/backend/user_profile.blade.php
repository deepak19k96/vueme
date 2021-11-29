@extends('layouts.app-dashboard')

@section('content')
    <div class="container container-gray-area p-3">
        <user-profile :countries="{{json_encode($countries)}}"
         :states="{{json_encode($states)}}" 
         :timezones="{{json_encode($timezones)}}"
        :country_all="{{json_encode($country_all)}}"></user-profile>
    </div>
@endsection


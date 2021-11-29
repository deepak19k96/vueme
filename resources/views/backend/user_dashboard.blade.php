@extends('layouts.app-dashboard')

@section('content')

<user-appointments :user="{{Auth::user()}}" :categories="{{json_encode($categories)}}" :apid="{{json_encode($apid)}}"></user-appointments>

@endsection
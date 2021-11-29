@extends('layouts.app-dashboard')

@section('content')
    <credit_logs :transactions="{{json_encode($transactions)}}" :name="{{json_encode($name)}}"> </credit_logs>
    <!-- <credit_logs> </credit_logs> -->
@endsection

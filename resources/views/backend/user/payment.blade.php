@extends('layouts.app-dashboard')

@section('content')
<payment :cards={{json_encode($cards)}}></payment>
@endsection

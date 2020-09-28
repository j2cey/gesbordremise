@extends('app')

@section('app_content')
    <bordereauremise-show :bordereauremise_prop="{{ $bordereauremise->toJson() }}" :actionvalues_prop="{{ $actionvalues }}"></bordereauremise-show>
@endsection

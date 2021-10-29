@extends('adminlte::page')

@section('title', 'Праздничные дни')

@section('content_header')
    <h1>Праздничные дни</h1>
@endsection

@section('content')

@include('admin.holidayDays.calendar')

@endsection

@push('css')
@endpush
@push('js')
@endpush

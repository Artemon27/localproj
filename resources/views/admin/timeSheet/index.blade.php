@extends('adminlte::page')

@section('title', 'Отпуска')

@section('content_header')
    <h1>Отпуска</h1>
@endsection

@section('content')

@include('admin.offhours.calendar')

@endsection

@push('css')
@endpush
@push('js')
@endpush

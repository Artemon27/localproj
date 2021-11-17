@extends('adminlte::page')

@section('title', 'Настройки')

@section('content_header')
    <h1>Настройки</h1>
@endsection

@section('content')
<form action="{{ route('admin.settings.store') }}" method="post">
<div class="col-12">
    <div class="card">
        @include ('modules.messages')
        <div class="card-header">
            <div class="row">
                <div class="col">
                        @csrf    
                        <button class="btn btn-primary" type="submit">Сохранить</button>
                </div>
                <div class="col">
                </div>                
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th width="5%">Опция</th>
                        <th width="5%">Значение</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($settings as $setting)
                    <tr>           
                        <td>{{ $setting->title }}</td>
                        <td><input type="{{$setting->format}}" name="{{$setting->option}}" value="{{ $setting->value }}"></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Список пуст</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</form>
@endsection

@push('css')
<style>
</style>
@endpush
@push('js')
<script>
    
</script>
@endpush

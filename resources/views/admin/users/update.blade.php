@extends('adminlte::page')

@section('title', 'Пользователи')

@section('content_header')
    <h1>Редактировать пользователя</h1>
@endsection

@section('content')
    <div class="col-xl-4 col-md-6 col-xs-12">
        <form action="{{ route('admin.users.update', $user) }}" method="post">
            @csrf
            @method('put')
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 text-left">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-warning">Назад</a>
                            <button class="btn btn-success" type="submit">Сохранить</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Имя</label>
                        <input
                            name="name"
                            class="form-control form-control-sm {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            type="text"
                            value="{{ old('name') ?? $user->name }}"
                        />
                        @foreach ($errors->get('name') as $error)
                            <span class="invalid-feedback">{{ $error }}</span>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input
                            name="email"
                            class="form-control form-control-sm {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            type="text"
                            value="{{ old('email') ?? $user->email }}"
                        />
                        @foreach ($errors->get('email') as $error)
                            <span class="invalid-feedback">{{ $error }}</span>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label>Роль</label>
                        <select
                            name="role"
                            class="form-control form-control-sm {{ $errors->has('role') ? 'is-invalid' : '' }}"
                        >
                            <option value="{{ \App\Models\User::ROLE_USER }}">Пользователь</option>
                            <option value="{{ \App\Models\User::ROLE_ADMIN }}">Админ</option>
                        </select>
                        @foreach ($errors->get('role') as $error)
                            <span class="invalid-feedback">{{ $error }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('css')
    <style>
        textarea {
            resize: none;
        }
    </style>
@endpush

@prepend('js')
@endprepend

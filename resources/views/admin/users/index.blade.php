@extends('adminlte::page')

@section('title', 'Пользователи')

@section('content_header')
    <h1>Пользователи</h1>
@endsection

@section('content')
<div class="col-12">
    <div class="card">
        @include ('modules.messages')
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <form action="{{ route('users-update') }}" method="post">
                        @csrf    
                        <button class="btn btn-success" type="submit">Обновить данные пользователей</button>
                    </form>
                </div>
                <div class="col">
                    {{ $users->links() }}
                </div>                
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="20%">Имя</th>
                        <th width="10%">Отдел</th>
                        <th width="10%">Таб.номер</th>
                        <th width="20%">Должность</th>
                        <th width="20%">Email</th>
                        <th width="10%">Роль</th>
                        <th width="5%">Действия</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->department }}</td>
                        <td>{{ $user->pager }}</td>
                        <td>{{ $user->title }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roleAsString() }}</td>
                        <td class="text-center">
                            <a class="delete text-red"
                               data-id="{{ $user->id }}"
                               type="button"
                               data-bs-toggle="modal"
                               data-bs-target="#delete_modal"
                            >
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </td>
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
    <div class="modal fade" id="delete_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Подтвердите удаление</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="$('#delete_modal').modal('hide')">Отмена</button>
                    <button id="delete_user" type="button" class="btn btn-danger">Удалить</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .delete {
        cursor: pointer;
    }
    .delete:hover {
        color: #d32f2f !important;
    }
    .pagination {
        float: right;
    }
</style>
@endpush
@push('js')
<script>
  $(document).ready(function() {
    let selectedUser

    $('.delete').on('click', function () {
      selectedUser = $(this).attr('data-id')
      $('#delete_modal').modal('show');
    })

    $('#delete_user').on('click', function (e) {
      e.preventDefault()
      $.ajax({
        url: `/admin/users/${selectedUser}`,
        data: {
          '_token': '{{ csrf_token() }}'
        },
        type: 'DELETE',
        success: function () {
          location.reload()
        }
      })
    })

  })
</script>
@endpush

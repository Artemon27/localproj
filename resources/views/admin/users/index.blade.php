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
                <div class='col text-center'>
                  <form action="{{ route('admin.users.search') }}" method="post" >
                    @csrf
                    @if(isset($srch))
                      <input type='text' name='srch' value="{{$srch}}">
                    @else
                      <input type='text' name='srch'>
                    @endif
                    <button class="btn btn-success" type="submit">Поиск</button>
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
                        <th width="5%">№</a>
                          @if(isset($srch))
                            @if (($name == 'name')&&($sort=='asc'))
                                <th width="20%"><a href="{{route('admin.users.search',['srch'=>$srch, 'name' => $name,'sort'=>'desc'])}}">Имя</a></th>
                            @else
                                <th width="20%"><a href="{{route('admin.users.search',['srch'=>$srch, 'name' => 'name'])}}">Имя</a></th>
                            @endif
                            @if (($name == 'department')&&($sort=='asc'))
                                <th width="10%"><a href="{{route('admin.users.search',['srch'=>$srch, 'name' => $name,'sort'=>'desc'])}}">Отдел</a></th>
                            @else
                                <th width="10%"><a href="{{route('admin.users.search',['srch'=>$srch, 'name' => 'department'])}}">Отдел</a></th>
                            @endif
                            @if (($name == 'pager')&&($sort=='asc'))
                                <th width="10%"><a href="{{route('admin.users.search',['srch'=>$srch, 'name' => $name,'sort'=>'desc'])}}">Таб.номер</a></th>
                            @else
                                <th width="10%"><a href="{{route('admin.users.search',['srch'=>$srch, 'name' => 'pager'])}}">Таб.номер</a></th>
                            @endif
                            @if (($name == 'title')&&($sort=='asc'))
                                <th width="20%"><a href="{{route('admin.users.search',['srch'=>$srch, 'name' => $name,'sort'=>'desc'])}}">Должность</a></th>
                            @else
                                <th width="20%"><a href="{{route('admin.users.search',['srch'=>$srch, 'name' => 'title'])}}">Должность</a></th>
                            @endif
                            @if (($name == 'email')&&($sort=='asc'))
                                <th width="20%"><a href="{{route('admin.users.search',['srch'=>$srch, 'name' => $name,'sort'=>'desc'])}}">Email</a></th>
                            @else
                                <th width="20%"><a href="{{route('admin.users.search',['srch'=>$srch, 'name' => 'email'])}}">Email</a></th>
                            @endif
                            @if (($name == 'role')&&($sort=='asc'))
                                <th width="20%"><a href="{{route('admin.users.search',['srch'=>$srch, 'name' => $name,'sort'=>'desc'])}}">Роль</a></th>
                            @else
                                <th width="20%"><a href="{{route('admin.users.search',['srch'=>$srch, 'name' => 'role'])}}">Роль</a></th>
                            @endif
                          @else
                            @if (($name == 'name')&&($sort=='asc'))
                                <th width="20%"><a href="{{route('admin.users.index',['name' => $name,'sort'=>'desc'])}}">Имя</a></th>
                            @else
                                <th width="20%"><a href="{{route('admin.users.index',['name' => 'name'])}}">Имя</a></th>
                            @endif
                            @if (($name == 'department')&&($sort=='asc'))
                                <th width="10%"><a href="{{route('admin.users.index',['name' => $name,'sort'=>'desc'])}}">Отдел</a></th>
                            @else
                                <th width="10%"><a href="{{route('admin.users.index',['name' => 'department'])}}">Отдел</a></th>
                            @endif
                            @if (($name == 'pager')&&($sort=='asc'))
                                <th width="10%"><a href="{{route('admin.users.index',['name' => $name,'sort'=>'desc'])}}">Таб.номер</a></th>
                            @else
                                <th width="10%"><a href="{{route('admin.users.index',['name' => 'pager'])}}">Таб.номер</a></th>
                            @endif
                            @if (($name == 'title')&&($sort=='asc'))
                                <th width="20%"><a href="{{route('admin.users.index',['name' => $name,'sort'=>'desc'])}}">Должность</a></th>
                            @else
                                <th width="20%"><a href="{{route('admin.users.index',['name' => 'title'])}}">Должность</a></th>
                            @endif
                            @if (($name == 'email')&&($sort=='asc'))
                                <th width="20%"><a href="{{route('admin.users.index',['name' => $name,'sort'=>'desc'])}}">Email</a></th>
                            @else
                                <th width="20%"><a href="{{route('admin.users.index',['name' => 'email'])}}">Email</a></th>
                            @endif
                            @if (($name == 'role')&&($sort=='asc'))
                                <th width="20%"><a href="{{route('admin.users.index',['name' => $name,'sort'=>'desc'])}}">Роль</a></th>
                            @else
                                <th width="20%"><a href="{{route('admin.users.index',['name' => 'role'])}}">Роль</a></th>
                            @endif
                          @endif
                        <th width="5%">Действия</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $i=$users->firstItem();
                @endphp
                @forelse($users as $num => $user)
                    <tr>
                        <td>{{ $i++ }}</td>
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

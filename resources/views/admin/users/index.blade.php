@extends('adminlte::page')

@section('title', 'Пользователи')

@section('content_header')
  <div class="row">
      <div class="col"><h1 class="">Пользователи</h1></div>
      <div class="col">
        <form action="{{ route('admin.users.search') }}" method="post" class="float-end">
          @csrf
          @if(isset($srch))
            <input type='text' name='srch' value="{{$srch}}">
          @else
            <input type='text' name='srch'>
          @endif
          <button class="btn btn-success" type="submit">Поиск</button>
        </form>
      </div>
    </div>
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
                  <button class="btn btn-success new_user">Новый пользователь</button>
                </div>
                <div class="col">
                  <form action="{{ route('admin.users.CreateTableUsers') }}" method="post">
                    @csrf
                    <div class="float-start">
                      <div class='select'>
                        Выбрать поля
                      </div>
                      <div class='select_body h-auto'>
                        <div><input type='checkbox' name='fields[0]' value="name" checked><span> ФИО</span></div>
                        <div><input type='checkbox' name='fields[1]' value="email" checked><span> Email</span></div>
                        <div><input type='checkbox' name='fields[2]' value="role" checked><span> Роль</span></div>
                        <div><input type='checkbox' name='fields[3]' value="pager" checked><span> Пропуск</span></div>
                        <div><input type='checkbox' name='fields[4]' value="department" checked><span> Отдел</span></div>
                        <div><input type='checkbox' name='fields[5]' value="title" checked><span> Должность</span></div>
                        <div><input type='checkbox' name='fields[6]' value="physicalDeliveryOfficeName" checked><span> Кабинет</span></div>
                        <div><input type='checkbox' name='fields[7]' value="telephoneNumber" checked><span> Телефон кабинета</span></div>
                        <div><input type='checkbox' name='fields[8]' value="pechat" checked><span> Печать</span></div>
                        <div><input type='checkbox' name='fields[9]' value="mobile" checked><span> Мобильный телефон</span></div>
                    </div>
                  </div>
                  @if(isset($srch))
                    <input type='hidden' name='srch' value="{{$srch}}">
                  @else
                    <input type='hidden' name='srch'>
                  @endif
                  <button class="btn btn-success float-start ms-2" type="submit">Таблица</button>
                </form>
                </div>
                @if(count($users->links()->elements[0])>1)
                <div class="col">
                    {{ $users->links() }}
                </div>
                @endif
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
<div class='background_new_user position-absolute w-100 h-100 bg-black d-none'></div>
<div class="new_user_fields bg-white position-absolute d-none">
  <span class="position-absolute btn">X</span>
  <form class="p-5 text-center" method="post" action="{{ route('admin.users.addUser') }}">
    @csrf
    <div class='ms-2'>Добавление нового пользователя</div>
    <input type="text" name="name" placeholder="ФИО" size='50' class="m-1">
    <input type="text" name="pager" placeholder="Пропуск" size='50' class="m-1">
    <input type="text" name="department" placeholder="Отдел" size='50' class="m-1">
    <input type="text" name="email" placeholder="Email" size='50' class="m-1">
    <input type="text" name="title" placeholder="Должность" size='50' class="m-1">
    <input type="text" name="physicalDeliveryOfficeName" placeholder="Кабинет" size='50' class="m-1">
    <input type="text" name="telephoneNumber" placeholder="Телефон кабинета" size='50' class="m-1">
    <input type="text" name="pechat" placeholder="Печать" size='50' class="m-1">
    <input type="text" name="mobile" placeholder="Мобильный телефон" size='50' class="m-1">
    <button type="submit" class="btn btn-success m-2">Добавить</button>
  </form>
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
<script src="{{asset('js/adminjs.js')}}"></script>
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

<div class="btn-group dropstart">
    <button type="button"  class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        МЕНЮ
    </button>
    <ul class="dropdown-menu" style="">
        <li><div class="dropdown-header text-primary fs-6">{{Auth::user()->name}}</div></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="/">Главная</a></li>
        @if (Auth::user()->role > 8)
        <li><a class="dropdown-item" href="/admin">Админка</a></li>
        <li><a class="dropdown-item" href="/offhours">Запись на вечер</a></li>
        <li><a class="dropdown-item" href="/timeSheet">Табель рабочего времени</a></li>
        <li><a class="dropdown-item" href="/keys">Ключи</a></li>
        @endif
        <li><a type="button" class="dropdown-item btn btn-primary" data-bs-toggle="modal" data-bs-target="#aboutModale" href="#">О нас</a></li>
        <li><a onclick="logout()" class="dropdown-item" href="#">Выйти</a></li>
    </ul>
</div>
<div class="modal fade text-dark" id="aboutModale" data-bs-backdrop="true" data-bs-keyboard="true" aria-labelledby="aboutModale" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header justify-content-center">
        <div class="modal-title text-center" id="staticBackdropLabel">
            Веб-сервис «Отпуск» предоставляет пользователю (сотруднику) возможность с рабочего персонального компьютера осуществлять запись, просмотр отпуска.
        </div>
      </div>
      <div class="modal-body text-start">
          <b>Разработано:</b><br>
            Костишин М.О.<br>
            Маркелов А.В.<br>
            Рогов И.В.<br>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

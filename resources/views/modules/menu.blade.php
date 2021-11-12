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
        @endif
        <li><a onclick="logout()" class="dropdown-item" href="#">Выйти</a></li>
    </ul>
</div>
<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

use Illuminate\Contracts\View\View;

use App\Http\Requests\Admin\UserRequest;
use Adldap\Laravel\Facades\Adldap;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $user=Adldap::search()->users()->get();
        #echo($user[0]['pager'][0]); #таб номер
        #echo($user[0]['department'][0]);#Отдел
        #homePhone ( Рабочий телефон )
        #mail
        #objectGUID
        #sAMAccountName логин userPrincipalName
        
    }
}

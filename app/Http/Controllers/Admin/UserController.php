<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Adldap\Models\Attributes\Guid;
use Illuminate\Support\Facades\Hash;
use Adldap\Laravel\Facades\Adldap;

use Symfony\Component\HttpFoundation\Request;
use App\Http\Requests\Admin\UserRequest;



use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $name = $request->get('name') ?? 'name';
        $sort = $request->get('sort') ?? 'asc';
        
        $users = User::query()
                ->select(['id', 'name', 'email', 'role','department','pager','title','physicalDeliveryOfficeName','telephoneNumber'])
                ->orderBy($name, $sort)
                ->paginate('30');        
        
        $users->appends(['name' => $name]);
        $users->appends(['sort' => $sort]);
        
        return view('admin.users.index', [
            'users' => $users
        , 'name' => $name, 'sort' => $sort]);    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     *
     * @return RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {
        User::create($request->all());

        return redirect()->route('admin.users.index')->with('success', 'Пользователь добавлен');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     *
     * @return View
     */
    public function edit(User $user): View
    {
        return view('admin.users.update', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->all());

        return redirect()->route('admin.users.index')->with('success', 'Пользователь обновлён');
    }


    public function updateldap() {
        $wheres = [
            'objectClass' => 'person',
            'memberOf' => 'CN=ВСЕ-НИЦ-1,OU=NIC-1,DC=nic1,DC=elavt,DC=spb,DC=ru'
        ];
        $users=Adldap::search()->users()->where($wheres)->select('name','password','objectguid','department','homePhone','userprincipalname','mail','sAMAccountName','title','pager','physicalDeliveryOfficeName','telephoneNumber')->get();
        if (count($users)){
            foreach ($users as $user){
                $objectguid = (string) new Guid($user->getObjectGuid());
                $newUser = User::Where('objectguid','=',$objectguid)->first();

                if (empty($newUser)){
                    $newUser = new User;
                }
                $newUser->name = $user->getName();
                $newUser->objectguid = (string) new Guid($user->getObjectGuid());
                $newUser->sAMAccountName = $user->getAccountName();

                $polouts = ['pager','department','homePhone','userprincipalname','mail','title','physicalDeliveryOfficeName','telephoneNumber'];
                $polin = ['pager','department','homePhone','email','mail','title','physicalDeliveryOfficeName','telephoneNumber'];

                foreach($polouts as $index => $polout){
                    if (isset($user[$polout][0])){
                        $newUser->{$polin[$index]} = $user[$polout][0];
                    }
                }
                $newUser->password=Hash::make('Elavt123');

                $newUser->save();
            }
        }
        return back()->with('success', 'Обновлено');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     *
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        try {
            if (count ($user->holidays)){
                foreach ($user->holidays as $holiday){
                    $holiday->delete;
                }
            }
            $user->delete();
        } catch (\Throwable $e) {
            return new JsonResponse(['message' => 'Ошибка удаление'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['message' => 'Удалено']);
    }
}

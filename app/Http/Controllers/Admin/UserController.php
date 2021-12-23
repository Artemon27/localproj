<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Adldap\Models\Attributes\Guid;
use Illuminate\Support\Facades\Hash;
use Adldap\Laravel\Facades\Adldap;
use SimpleXMLElement;
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
        , 'name' => $name, 'sort' => $sort]);
      }

        public function search(Request $request): View
        {
            $srch=$request["srch"];
            $name = $request->get('name') ?? 'name';
            $sort = $request->get('sort') ?? 'asc';

            $users = User::query()
                    ->select(['id', 'name', 'email', 'role','department','pager','title','physicalDeliveryOfficeName','telephoneNumber'])
                    ->orderBy($name, $sort)
                    ->orWhere('name','LIKE','%'.$srch.'%')
                    ->orWhere('email','LIKE','%'.$srch.'%')
                    ->orWhere('role','LIKE','%'.$srch.'%')
                    ->orWhere('department','LIKE','%'.$srch.'%')
                    ->orWhere('pager','LIKE','%'.$srch.'%')
                    ->orWhere('title','LIKE','%'.$srch.'%')
                    ->paginate('30');

            $users->appends(['name' => $name]);
            $users->appends(['sort' => $sort]);

            return view('admin.users.index', [
                'users' => $users
            , 'name' => $name, 'sort' => $sort, 'srch' => $srch]);
          }

          public function CreateTableUsers(Request $request)
          {
            $sxe = new SimpleXMLElement('UsersTemplate.xml', 0, TRUE);//создание файла
            $i=1; $l=-1;
            $fields_all = array('name' => 1, 'email' => 2, 'role' => 3, 'pager' => 4, 'department' => 5, 'title' => 6, 'physicalDeliveryOfficeName' => 7, 'telephoneNumber' => 8, 'pechat' => 9, 'mobile' => 10 );
            $fields_select = $request['fields'];
            $srch=$request["srch"];
            $stylename='s81';
            $styleother='s70';
            $users = User::query()
                    ->select(['name', 'email', 'role','pager','department','title','physicalDeliveryOfficeName','telephoneNumber', 'pechat', 'mobile'])
                    ->orderBy('name', 'asc')
                    ->orWhere('name','LIKE','%'.$srch.'%')
                    ->orWhere('email','LIKE','%'.$srch.'%')
                    ->orWhere('role','LIKE','%'.$srch.'%')
                    ->orWhere('department','LIKE','%'.$srch.'%')
                    ->orWhere('pager','LIKE','%'.$srch.'%')
                    ->orWhere('title','LIKE','%'.$srch.'%')
                    ->paginate('300');

            $allchild = $sxe->children();

            foreach ($allchild->Worksheet->Table->Column as $val) {
              $l++; $select=false;
              foreach ($fields_select as $field) {
                if($l == $fields_all[$field] || $l == 0){
                  $select=true;
                  break;
                }
              }
              if($select==false)
                $val->addAttribute('xmlns:ss:Hidden',"1" );
            }

            foreach ($users as $user) {
              $row = $allchild->Worksheet->Table->addChild('Row');
              $cell = $row->addChild('Cell');
              $cell->addAttribute('xmlns:ss:StyleID',$styleother );
              $cell->addChild('Data',(string) $i++)->addAttribute('xmlns:ss:Type',"String" );

              $cell = $row->addChild('Cell');
              $cell->addAttribute('xmlns:ss:StyleID',$stylename );
              $cell->addChild('Data',$user['name'])->addAttribute('xmlns:ss:Type',"String" );

              $cell = $row->addChild('Cell');
              $cell->addAttribute('xmlns:ss:StyleID',$styleother );
              $cell->addChild('Data',$user['email'])->addAttribute('xmlns:ss:Type',"String" );

              $cell = $row->addChild('Cell');
              $cell->addAttribute('xmlns:ss:StyleID',$styleother );
              $cell->addChild('Data',$user->roleAsString())->addAttribute('xmlns:ss:Type',"String" );

              $cell = $row->addChild('Cell');
              $cell->addAttribute('xmlns:ss:StyleID',$styleother );
              $cell->addChild('Data',$user['pager'])->addAttribute('xmlns:ss:Type',"String" );

              $cell = $row->addChild('Cell');
              $cell->addAttribute('xmlns:ss:StyleID',$styleother );
              $cell->addChild('Data',$user['department'])->addAttribute('xmlns:ss:Type',"String" );

              $cell = $row->addChild('Cell');
              $cell->addAttribute('xmlns:ss:StyleID',$styleother );
              $cell->addChild('Data',$user['title'])->addAttribute('xmlns:ss:Type',"String" );

              $cell = $row->addChild('Cell');
              $cell->addAttribute('xmlns:ss:StyleID',$styleother );
              $cell->addChild('Data',$user['physicalDeliveryOfficeName'])->addAttribute('xmlns:ss:Type',"String" );

              $cell = $row->addChild('Cell');
              $cell->addAttribute('xmlns:ss:StyleID',$styleother );
              $cell->addChild('Data',$user['telephoneNumber'])->addAttribute('xmlns:ss:Type',"String" );

              $cell = $row->addChild('Cell');
              $cell->addAttribute('xmlns:ss:StyleID',$styleother );
              $cell->addChild('Data',$user['pechat'])->addAttribute('xmlns:ss:Type',"String" );

              $cell = $row->addChild('Cell');
              $cell->addAttribute('xmlns:ss:StyleID',$styleother );
              $cell->addChild('Data',$user['mobile'])->addAttribute('xmlns:ss:Type',"String" );
            }

            $sxe->asXML('TableUsers.xml');

            return response()->download('TableUsers.xml');
          }

          public function addUser(Request $request)
          {
            $data['role']=1;
            $data['username']=null;
            $data['email_verified_at']=null;
            $data['password']=1;
            $data['objectguid']=1;
            $data['homePhone']=null;
            $data['mail']=null;
            $data['sAMAccountName']=1;
            $data['name']=$request['name'];
            $data['pager']=$request['pager'];
            $data['department']=$request['department'];
            $data['email']=$request['email'];
            $data['title']=$request['title'];
            $data['physicalDeliveryOfficeName']=$request['physicalDeliveryOfficeName'];
            $data['telephoneNumber']=$request['telephoneNumber'];
            $data['pechat']=$request['pechat'];
            $data['mobile']=$request['mobile'];
            User::Create($data);

            $name = 'name';
            $sort = 'asc';

            $users = User::query()
                    ->select(['id', 'name', 'email', 'role','department','pager','title','physicalDeliveryOfficeName','telephoneNumber'])
                    ->orderBy($name, $sort)
                    ->paginate('30');

            $users->appends(['name' => $name]);
            $users->appends(['sort' => $sort]);

            return view('admin.users.index', [
                'users' => $users
            , 'name' => $name, 'sort' => $sort]);
          }

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
        $users=Adldap::search()->users()->where($wheres)->select('name','password','objectguid','department','homePhone','userprincipalname','mail','sAMAccountName','title','pager','physicalDeliveryOfficeName','telephoneNumber','facsimileTelephoneNumber','mobile')->get();
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

                $polouts = ['pager','department','homePhone','userprincipalname','mail','title','physicalDeliveryOfficeName','telephoneNumber','facsimileTelephoneNumber','mobile'];
                $polin = ['pager','department','homePhone','email','mail','title','physicalDeliveryOfficeName','telephoneNumber','pechat','mobile'];

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

    public function migrate()
    {
        Artisan::call('migrate');
        back();
    }
}

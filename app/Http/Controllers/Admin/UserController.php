<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

use Illuminate\Contracts\View\View;

use App\Http\Requests\Admin\UserRequest;

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
        return view('admin.users.index', [
            'users' => User::query()
                ->select(['id', 'name', 'email', 'role'])                
                ->latest()
                ->paginate()
        ]);
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
            $user->delete();
        } catch (\Throwable $e) {
            return new JsonResponse(['message' => 'Ошибка удаление'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['message' => 'Удалено']);
    }
}

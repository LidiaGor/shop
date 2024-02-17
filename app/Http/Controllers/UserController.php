<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

use function Laravel\Prompts\password;

class UserController extends Controller
{

    public function __construct()
    {
        //лучше добавить browse_users, но это лишний пермишн пока
        $this->middleware('permission:add_users|edit_users', ['only' => 'index']);
        $this->middleware('permission:add_users', ['only' => 'store']);
        $this->middleware('permission:edit_users', ['only' => 'update']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query()
            ->with('roles:id,description')
            ->select(
                'id',
                'name',
                'email'
            )
            ->when(!Auth::user()->can('can_change_admins'), function (Builder $query) {
                $query->whereHas('roles', function (Builder $query) {
                    $query->where('id', '<>', 1); //role not admin
                });
            })
            ->get();

        $roles = Role::query()
            ->when(!Auth::user()->can('can_change_admins'), function (Builder $query) {
                $query->where('id', '<>', 1);
            })
            ->select('id', 'name', 'description')
            ->get();

        return Inertia::render(
            'User/UserIndex',
            compact('users', 'roles')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserAddRequest $request)
    {
        $req = $request->validated();

        $user = new User();
        $user->name = $req['name'];
        $user->email = $req['email'];
        $user->password = Hash::make($req['password']);
        $user->syncRoles($req['roles']);
        $user->save();

        return Redirect::route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $req = $request->validated();
        $user->name = $req['name'];
        $user->email = $req['email'];

        if ($req['password']) {
            $user->password = Hash::make($req['password']);
        }

        $user->syncRoles($req['roles']);

        $user->save();

        return Redirect::route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}

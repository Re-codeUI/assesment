<?php

namespace App\Http\Controllers\User;

use DB;
use Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request): View{
        $data = User::latest()->paginate(5);

        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create(): View{
        $roles = Role::pluck('name','name')->all();

        return view('users.create',compact('roles'));
    }

    public function store(Request $request): RedirectResponse{
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $request->merge(['password' => bcrypt($request->get('password'))]);

        if($user = User::create($request->except('roles'))){
            $user->syncRoles($request->get('roles'));

            flash()->success('Pengguna berhasil ditambahkan');

        }else{
            flash()->error('Tidak dapat menambahkan pengguna');
        }

        return redirect()->route('users');
    }

    public function show($id): View{
        $user = User::find($id);

        return view('users.show',compact('user'));
    }

    public function edit($id): View{
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        return view('users.edit',compact('user','roles','userRole'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        $user = User::find($id);
        if ($user->update($input)) {
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $user->assignRole($request->input('roles'));
    
            flash()->success('Pengguna berhasil diperbarui');
        } else {
            flash()->error('Tidak dapat memperbarui pengguna');
        }

        return redirect()->route('users');
    }

    public function destroy($id): RedirectResponse{
        $user = User::find($id);
        if ($user) {
            $user->delete();
            flash()->success('Pengguna berhasil dihapus');
        } else {
            flash()->error('Tidak dapat menghapus pengguna');
        }
        return redirect()->route('users');
    }
}

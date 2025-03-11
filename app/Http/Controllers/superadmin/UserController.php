<?php

namespace App\Http\Controllers\superadmin;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\superadmin\UserRequest;
use App\Http\Requests\superadmin\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prodiSearch = request()->input('department');
        $roleSearch = request()->input('role');

        $departments = Department::orderByRaw("CASE WHEN parent_id IS NULL THEN id ELSE parent_id END, parent_id IS NOT NULL, name")->get();

        $users = $this->search($prodiSearch, $roleSearch, 10)->withQueryString();
        
        return view('superadmin.akun.index',[
            'title' => 'Daftar User',
            'users' => $users,
            'departments' => $departments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::orderByRaw("CASE WHEN parent_id IS NULL THEN id ELSE parent_id END, parent_id IS NOT NULL, name")->get();

        return view('superadmin.akun.create', [
            'title' => 'Tambah User',
            'departments' => $departments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        User::create($request->all());

        return redirect('/superadmin/user')->with('success', 'User <b>' . $request->username . '</b> berhasil ditambahkan');
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
        $departments = Department::orderByRaw("CASE WHEN parent_id IS NULL THEN id ELSE parent_id END, parent_id IS NOT NULL, name")->get();

        return view('superadmin.akun.edit', [
            'title' => 'Edit User',
            'user' => $user,
            'departments' => $departments
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'department_id' => $request->department_id,
            'role' => $request->role,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect('/superadmin/user')->with('success', 'User <b>' . $request->name . '</b> berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/superadmin/user')->with('success', 'User <b>' . $user->name . '</b> berhasil dihapus');
    }

    private function search(int $department = null, string $role = null,  int $paginate = 10){
        $query = User::query();

        if ($department) {
            $query->where('department_id', $department);
        }

        if ($role) {
            $query->where('role', $role);
        }

        return $query->paginate($paginate);
    }
}

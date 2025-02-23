<?php

namespace App\Http\Controllers\superadmin;

use App\Models\User;
use App\Models\ProgramStudi;
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
        $prodiSearch = request()->input('prodi');
        $roleSearch = request()->input('role');

        $prodis = ProgramStudi::where('id', '>', 1)->orderBy('nama', 'asc')->get();

        $users = $this->search($prodiSearch, $roleSearch, 10)->withQueryString();
        
        return view('superadmin.akun.index',[
            'title' => 'Super Admin Daftar User',
            'users' => $users,
            'prodis' => $prodis,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prodis = ProgramStudi::where('id', '>', 1)->orderBy('nama', 'asc')->get();

        return view('superadmin.akun.create', [
            'title' => 'Super Admin Tambah User',
            'prodis' => $prodis
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
        $prodis = ProgramStudi::where('id', '>', 1)->orderBy('nama', 'asc')->get();

        return view('superadmin.akun.edit', [
            'title' => 'Super Admin Edit User',
            'user' => $user,
            'prodis' => $prodis
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
            'program_studi_id' => $request->program_studi_id,
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

    private function search(int $prodi = null, string $role = null,  int $paginate = 10){
        $query = User::query();

        $query->where('id', '>', 1);

        if ($prodi) {
            $query->where('program_studi_id', $prodi);
        }

        if ($role) {
            $query->where('role', $role);
        }

        return $query->paginate($paginate);
    }
}

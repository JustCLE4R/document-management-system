<?php

namespace App\Http\Controllers\superadmin;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $term = $request->input('result');

        $departments = $this->search($term, 10)->withQueryString();

        return view('superadmin.department.index', [
            'title' => 'Super Admin Daftar Department',
            'departments' => $departments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.department.create', [
            'title' => 'Super Admin Tambah Department',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ],
        [
            'name.required' => 'Department harus diisi',
        ],
        [
            'name' => 'Department',
        ]);

        Department::create([
            'name' => $request->input('name'),
        ]);

        return redirect('/superadmin/department')->with('success', 'Department <b>' . $request->input('name') . '</b> berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('superadmin.department.edit', [
            'title' => 'Super Admin Edit Department',
            'department' => $department
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required',
        ],
        [
            'name.required' => 'Department harus diisi',
        ],
        [
            'name' => 'Department',
        ]);

        $department->update([
            'name' => $request->input('name'),
        ]);

        return redirect('/superadmin/department')->with('success', 'Department <b>' . $department->name . '</b> berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return redirect('/superadmin/department')->with('success', 'Department <b>' . $department->name . '</b> berhasil dihapus!');
    }

    private function search(string $term = null, int $paginate = 6) : object
    {
        $query = Department::query();

        $query->where('id', '!=', 1);

        if ($term) {
            $query->where('name', 'like', "%{$term}%");
        }

        return $query->paginate($paginate);
    }
}

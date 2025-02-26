<?php

namespace App\Http\Controllers\superadmin;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\superadmin\DeparmentRequest;
use App\Http\Requests\superadmin\UpdateDepartmentRequest;

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
        $faculties = Department::where('type', 'faculty')->get();

        return view('superadmin.department.create', [
            'title' => 'Super Admin Tambah Department',
            'faculties' => $faculties
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DeparmentRequest $request)
    {
        Department::create([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'parent_id' => $request->input('parent_id'),
        ]);

        return redirect('/superadmin/department')->with('success', 'Department <b>' . $request->input('name') . '</b> berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        $faculties = Department::where('type', 'faculty')->get();

        return view('superadmin.department.edit', [
            'title' => 'Super Admin Edit Department',
            'department' => $department,
            'faculties' => $faculties
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department->update([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'parent_id' => $request->input('parent_id'),
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
        $query = Department::with('parent')
            ->orderByRaw("CASE WHEN parent_id IS NULL THEN id ELSE parent_id END, parent_id IS NOT NULL, name")
            ->newQuery();

        if ($term) {
            $query->where('name', 'like', "%{$term}%");
        }

        return $query->paginate($paginate);
    }
}

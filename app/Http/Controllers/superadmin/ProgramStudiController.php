<?php

namespace App\Http\Controllers\superadmin;

use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgramStudiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $term = $request->input('result');

        $prodis = $this->search($term, 10)->withQueryString();

        return view('superadmin.prodi.index', [
            'title' => 'Super Admin Daftar Program Studi',
            'prodis' => $prodis
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.prodi.create', [
            'title' => 'Super Admin Tambah Program Studi',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ],
        [
            'nama.required' => 'Program Studi harus diisi',
        ],
        [
            'nama' => 'Program Studi',
        ]);

        ProgramStudi::create([
            'nama' => $request->input('nama'),
        ]);

        return redirect('/superadmin/prodi')->with('success', 'Program Studi <b>' . $request->input('nama') . '</b> berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProgramStudi $prodi)
    {
        return view('superadmin.prodi.edit', [
            'title' => 'Super Admin Edit Program Studi',
            'prodi' => $prodi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProgramStudi $prodi)
    {
        $request->validate([
            'nama' => 'required',
        ],
        [
            'nama.required' => 'Program Studi harus diisi',
        ],
        [
            'nama' => 'Program Studi',
        ]);

        $prodi->update([
            'nama' => $request->input('nama'),
        ]);

        return redirect('/superadmin/prodi')->with('success', 'Program Studi <b>' . $prodi->nama . '</b> berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramStudi $prodi)
    {
        $prodi->delete();

        return redirect('/superadmin/prodi')->with('success', 'Program Studi <b>' . $prodi->nama . '</b> berhasil dihapus!');
    }

    private function search(string $term = null, int $paginate = 6) : object
    {
        $query = ProgramStudi::query();

        $query->where('id', '!=', 1);

        if ($term) {
            $query->where('nama', 'like', "%{$term}%");
        }

        return $query->paginate($paginate);
    }
}

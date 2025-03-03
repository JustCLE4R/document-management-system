<?php

namespace App\Http\Controllers\superadmin;

use App\Models\User;
use App\Models\Dokumen;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\superadmin\DokumenRequest;
use App\Http\Requests\superadmin\UpdateDokumenRequest;
use App\Models\Kriteria;

class DokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $term = $request->input('result');
        $kriteria = $request->input('kriteria');
        $tipe = $request->input('tipe');
        $department = $request->input('department');

        $dokumens = $this->search($term, $kriteria, $tipe, $department, 10);

        $departments = Department::orderByRaw("CASE WHEN parent_id IS NULL THEN id ELSE parent_id END, parent_id IS NOT NULL, name")->get();
        $kriterias = Kriteria::all();

        return view('superadmin.dokumen.index', [
            'title' => 'Super Admin Daftar Dokumen',
            'dokumens' => $dokumens,
            'departments' => $departments,
            'kriterias' => $kriterias
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kriterias = Kriteria::all();
        $users = User::where('role', '!=', 'user')->get()->unique('department_id');

        return view('superadmin.dokumen.create', [
            'title' => 'Super Admin Tambah Dokumen',
            'kriterias' => $kriterias,
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DokumenRequest $request)
    {
        $prepareData = $request->all();

        if ($request->hasFile('file')) {
            $prepareData['tipe'] = str_contains($request->file('file')->getMimeType(), 'pdf') ? 'PDF' : 'Image';
            $prepareData['path'] = $request->file('file')->store('dokumen');
        } else {
            $prepareData['tipe'] = 'URL';
            $prepareData['path'] = $prepareData['url'];
        }

        $prepareData['kriteria_id'] = $prepareData['kriteria'];

        Dokumen::create($prepareData);

        return redirect('/superadmin/dokumen')->with('success', 'Dokumen <b>' . $prepareData['name'] . '</b> berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dokumen $dokumen)
    {
        return view('superadmin.dokumen.show', [
            'title' => 'Super Admin Detail Dokumen',
            'dokumen' => $dokumen
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dokumen $dokumen)
    {
        $departments = Department::orderByRaw("CASE WHEN parent_id IS NULL THEN id ELSE parent_id END, parent_id IS NOT NULL, name")->get();
        $kriterias = Kriteria::all();

        return view('superadmin.dokumen.edit', [
            'departments' => $departments,
            'title' => 'Super Admin Edit Dokumen',
            'dokumen' => $dokumen,
            'kriterias' => $kriterias
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDokumenRequest $request, Dokumen $dokumen)
    {
        $dokumen->increment('revisions');

        $prepareData = $request->only(['name', 'kriteria', 'sub_kriteria', 'catatan']);

        if ($request->hasFile('file')) {
            if ($dokumen->tipe != 'URL') {
                Storage::delete($dokumen->path);
            }
            $prepareData['path'] = $request->file('file')->store('dokumen');
            $prepareData['tipe'] = str_contains($request->file('file')->getMimeType(), 'pdf') ? 'PDF' : 'Image';
        } elseif ($request->url) {
            if ($dokumen->tipe != 'URL') {
                Storage::delete($dokumen->path);
            }
            $prepareData['path'] = $request->url;
            $prepareData['tipe'] = 'URL';
        }

        $dokumen->update($prepareData);

        return redirect('/superadmin/dokumen')->with('success', 'Dokumen <b>' . $dokumen->name . '</b> berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dokumen $dokumen)
    {
        if($dokumen->tipe != 'URL'){
            Storage::delete($dokumen->path);
        }

        $dokumen->delete();
        return redirect('/superadmin/dokumen')->with('success', 'Dokumen <b>' . $dokumen->name . '</b> berhasil dihapus!');
    }

    /**
     * Search dokumen.
     */
    private function search(string $term = null, string $kriteria = null, string $tipe = null, int $department = null, int $paginate = 6) : object
    {
        $query = Dokumen::query();

        if ($term) {
            $query->where(function ($query) use ($term) {
            $query->where('name', 'like', '%' . $term . '%')
                ->orWhere('sub_kriteria', 'like', '%' . $term . '%')
                ->orWhere('catatan', 'like', '%' . $term . '%');
            });
        }

        if ($kriteria) 
            $query->where('kriteria_id', $kriteria);

        if ($tipe) 
            $query->where('tipe', $tipe);

        if ($department) 
            $query->whereHas('user.department', function ($query) use ($department) {
                $query->where('id', $department);
            });

        $query->orderByDesc('created_at');

        $results = $query->paginate($paginate)->appends(request()->query());

        return $results;
    }
}

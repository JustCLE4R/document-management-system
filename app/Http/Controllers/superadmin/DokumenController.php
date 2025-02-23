<?php

namespace App\Http\Controllers\superadmin;

use App\Models\User;
use App\Models\Dokumen;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\superadmin\DokumenRequest;
use App\Http\Requests\superadmin\UpdateDokumenRequest;

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
        $prodi = $request->input('prodi');

        $dokumens = $this->search($term, $kriteria, $tipe, $prodi, 10);

        $prodis = ProgramStudi::orderByRaw("id = 1 desc, nama asc")->get();

        return view('superadmin.dokumen.index', [
            'title' => 'Super Admin Daftar Dokumen',
            'dokumens' => $dokumens,
            'prodis' => $prodis,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prodis = ProgramStudi::orderByRaw("id = 1 desc, nama asc")->get();
        $users = User::where('role', '!=', 'user')->get()->unique('program_studi_id');

        return view('superadmin.dokumen.create', [
            'title' => 'Super Admin Tambah Dokumen',
            'prodis' => $prodis,
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DokumenRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('file')) {
            $data['tipe'] = str_contains($request->file('file')->getMimeType(), 'pdf') ? 'PDF' : 'Image';
            $data['path'] = $request->file('file')->store('dokumen');
        } else {
            $data['tipe'] = 'URL';
            $data['path'] = $data['url'];
        }

        Dokumen::create($data);

        return redirect('/superadmin/dokumen')->with('success', 'Dokumen <b>' . $data['nama'] . '</b> berhasil ditambahkan');
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
        $prodis = ProgramStudi::orderByRaw("id = 1 desc, nama asc")->get();

        return view('superadmin.dokumen.edit', [
            'prodis' => $prodis,
            'title' => 'Super Admin Edit Dokumen',
            'dokumen' => $dokumen
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDokumenRequest $request, Dokumen $dokumen)
    {
        $prepareData = $request->only(['nama', 'kriteria', 'sub_kriteria', 'catatan']);

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

        return redirect('/superadmin/dokumen')->with('success', 'Dokumen <b>' . $dokumen->nama . '</b> berhasil diubah');
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
        return redirect('/superadmin/dokumen')->with('success', 'Dokumen <b>' . $dokumen->nama . '</b> berhasil dihapus!');
    }

    /**
     * Search dokumen.
     */
    private function search(string $term = null, string $kriteria = null, string $tipe = null, int $prodi = null, int $paginate = 6) : object
    {
        $query = Dokumen::query();

        if ($term) {
            $query->where(function ($query) use ($term) {
            $query->where('nama', 'like', '%' . $term . '%')
                ->orWhere('sub_kriteria', 'like', '%' . $term . '%')
                ->orWhere('catatan', 'like', '%' . $term . '%');
            });
        }

        if ($kriteria) 
            $query->where('kriteria', $kriteria);

        if ($tipe) 
            $query->where('tipe', $tipe);

        if ($prodi) 
            $query->whereHas('user.programStudi', function ($query) use ($prodi) {
                $query->where('id', $prodi);
            });

        $query->orderByDesc('created_at');

        $results = $query->paginate($paginate)->appends(request()->query());

        return $results;
    }
}

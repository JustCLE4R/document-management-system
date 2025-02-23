<?php

namespace App\Http\Controllers\admin;

use App\Models\Dokumen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\admin\DokumenRequest;
use App\Http\Requests\admin\UpdateDokumenRequest;
use App\Http\Controllers\DokumenController as PublicDokumenController;

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

        $dokumens = (new PublicDokumenController)->search($term, $kriteria, $tipe, 10);

        return view('admin.dokumen.index', [
            'title' => 'Admin Daftar Dokumen',
            'dokumens' => $dokumens,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $shareables = Dokumen::where('status', 'share')->get();

        return view('admin.dokumen.create', [
            'title' => 'Admin Tambah Dokumen',
            'shareables' => $shareables
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DokumenRequest $request)
    {
        $prepareData = $request->except('shareable');

        if ($request->hasFile('file')) {
            $prepareData['path'] = $request->file('file')->store('dokumen');
            $prepareData['tipe'] = str_contains($request->file('file')->getMimeType(), 'pdf') ? 'PDF' : 'Image';
        } elseif ($request->tipe == 'url') {
            $prepareData['path'] = $request->url;
            $prepareData['tipe'] = 'URL';
        } elseif ($request->tipe == 'shareable') {
            $shareable_dokumen = Dokumen::findOrFail($request->shareable);
            $prepareData['status'] ='borrow';
            $prepareData['borrow_from'] = $request->shareable;
            $prepareData['path'] = $shareable_dokumen->path;
            $prepareData['tipe'] = $shareable_dokumen->tipe;
        }

        Dokumen::create($prepareData);

        return redirect('/admin/dokumen')->with('success', 'Dokumen <b>'. $request->nama . '</b> berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dokumen $dokumen)
    {
        if($dokumen->user->programStudi->id != Auth::user()->programStudi->id)
            return redirect('/admin/dokumen')->with('error', 'Dokumen tidak ditemukan');

        return view('admin.dokumen.show', [
            'title' => 'Admin Detail Dokumen',
            'dokumen' => $dokumen
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dokumen $dokumen)
    {
        if($dokumen->user->programStudi->id != Auth::user()->programStudi->id)
            return redirect('/admin/dokumen')->with('error', 'Dokumen tidak ditemukan');

        $shareables = Dokumen::where('status', 'share')->get();

        return view('admin.dokumen.edit', [
            'title' => 'Admin Edit Dokumen',
            'dokumen' => $dokumen,
            'shareables' => $shareables
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDokumenRequest $request, Dokumen $dokumen)
    {
        if($dokumen->user->programStudi->id != Auth::user()->programStudi->id)
            return redirect('/admin/dokumen')->with('error', 'Dokumen tidak ditemukan');

        $prepareData = $request->only(['nama', 'kriteria', 'sub_kriteria', 'catatan']);

        if ($request->hasFile('file')) {
            $prepareData['status'] ='private';
            $prepareData['path'] = $request->file('file')->store('dokumen');
            $prepareData['tipe'] = str_contains($request->file('file')->getMimeType(), 'pdf') ? 'PDF' : 'Image';
        } elseif ($request->tipe == 'url') {
            $prepareData['status'] ='private';
            $prepareData['path'] = $request->url;
            $prepareData['tipe'] = 'URL';
        } elseif ($request->tipe == 'shareable') {
            $shareable_dokumen = Dokumen::findOrFail($request->shareable);
            $prepareData['status'] ='borrow';
            $prepareData['borrow_from'] = $request->shareable;
            $prepareData['path'] = $shareable_dokumen->path;
            $prepareData['tipe'] = $shareable_dokumen->tipe;
        }


        $dokumen->update($prepareData);

        return redirect('/admin/dokumen')->with('success', 'Dokumen <b>' . $dokumen->nama . '</b> berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dokumen $dokumen)
    {
        if($dokumen->user->programStudi->id != Auth::user()->programStudi->id){
            return redirect('/admin/dokumen')->with('error', 'Dokumen tidak ditemukan');
        }

        if($dokumen['status'] != 'borrow'){
            Storage::delete($dokumen->path);
        }

        $dokumen->delete();
        return redirect('/admin/dokumen')->with('success', 'Dokumen <b>' . $dokumen->nama . '</b> berhasil dihapus!');
    }
}

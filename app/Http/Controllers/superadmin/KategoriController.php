<?php

namespace App\Http\Controllers\superadmin;

use App\Models\Kategori;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\admin\KategoriRequest;
use App\Http\Requests\admin\UpdateKategoriRequest;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kategoris = Kategori::query();

        if ($search) {
            $kategoris = $kategoris->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%")
                        ->orWhere('icon', 'LIKE', "%{$search}%")
                        ->orWhere('image', 'LIKE', "%{$search}%");
            });
        }

        $kategoris = $kategoris->orderBy('created_at')->paginate(10);
        $departments = Department::orderByRaw("CASE WHEN parent_id IS NULL THEN id ELSE parent_id END, parent_id IS NOT NULL, name")->get();

        return view('superadmin.kategori.index', [
            'kategoris' => $kategoris,
            'departments' => $departments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.kategori.create', [
            'title' => 'Admin Tambah Kategori',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KategoriRequest $request)
    {
        $prepareData = $request->except('image');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('kategori', 'public');
            $prepareData['image'] = $imagePath;
        }

        Kategori::create($prepareData);

        return redirect()->route('superadmin.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        $departments = Department::orderByRaw("CASE WHEN parent_id IS NULL THEN id ELSE parent_id END, parent_id IS NOT NULL, name")->get();

        return view('superadmin.kategori.edit', [
            'title' => 'Admin Edit Kategori',
            'kategori' => $kategori,
            'departments' => $departments,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriRequest $request, Kategori $kategori)
    {
        $prepareData = $request->except('image');

        if ($request->hasFile('image')) {
            if ($kategori->image) {
                Storage::disk('public')->delete($kategori->image);
            }
            $imagePath = $request->file('image')->store('kategori', 'public');
            $prepareData['image'] = $imagePath;
        }

        $kategori->update($prepareData);

        return redirect()->route('superadmin.kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        if ($kategori->image && $kategori->image !== 'kategori/default-kategori.svg') {
            Storage::disk('public')->delete($kategori->image);
        }

        $kategori->delete();

        return redirect()->route('superadmin.kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}

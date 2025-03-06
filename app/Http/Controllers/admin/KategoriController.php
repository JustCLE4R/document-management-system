<?php

namespace App\Http\Controllers\admin;

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

        $kategoris = Kategori::where(function ($query) {
            $query->where('department_id', Auth::user()->department_id)
            ->orWhere('department_id', 1);
        });

        if ($search) {
            $kategoris = $kategoris->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%")
                        ->orWhere('icon', 'LIKE', "%{$search}%")
                        ->orWhere('image', 'LIKE', "%{$search}%");
            });
        }

        $kategoris = $kategoris->orderBy('created_at')->paginate(10);

        return view('admin.kategori.index', [
            'kategoris' => $kategoris,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kategori.create', [
            'title' => 'Admin Tambah Kategori',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KategoriRequest $request)
    {
        $prepareData = $request->except('image');

        $prepareData['department_id'] = Auth::user()->department_id;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('kategori', 'public');
            $prepareData['image'] = $imagePath;
        }

        Kategori::create($prepareData);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
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
        if ($kategori->department_id !== Auth::user()->department_id) {
            abort(403);
        }

        $departments = Department::where('id', Auth::user()->department_id)->get();

        return view('admin.kategori.edit', [
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
        if ($kategori->department_id !== Auth::user()->department_id) {
            abort(403);
        }

        $prepareData = $request->except('image');

        if ($request->hasFile('image')) {
            if ($kategori->image) {
                Storage::disk('public')->delete($kategori->image);
            }
            $imagePath = $request->file('image')->store('kategori', 'public');
            $prepareData['image'] = $imagePath;
        }

        $kategori->update($prepareData);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        if ($kategori->department_id !== Auth::user()->department_id) {
            abort(403);
        }

        if ($kategori->image && $kategori->image !== 'kategori/default-kategori.svg') {
            Storage::disk('public')->delete($kategori->image);
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}

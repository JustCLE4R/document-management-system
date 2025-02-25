<?php

namespace App\Http\Controllers\superadmin;

use App\Models\Kriteria;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\admin\KriteriaRequest;
use App\Http\Requests\admin\UpdateKriteriaRequest;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kriterias = Kriteria::query();

        if ($search) {
            $kriterias = $kriterias->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%")
                        ->orWhere('icon', 'LIKE', "%{$search}%")
                        ->orWhere('image', 'LIKE', "%{$search}%");
            });
        }

        $kriterias = $kriterias->orderBy('created_at')->paginate(10);

        return view('superadmin.kriteria.index', [
            'kriterias' => $kriterias,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('superadmin.kriteria.create', [
            'title' => 'Admin Tambah Kriteria',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KriteriaRequest $request)
    {
        $prepareData = $request->except('image');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('kriteria', 'public');
            $prepareData['image'] = $imagePath;
        }

        Kriteria::create($prepareData);

        return redirect()->route('superadmin.kriteria.index')->with('success', 'Kriteria berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kriteria $kriteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kriteria $kriteria)
    {
        $departments = Department::all();

        return view('superadmin.kriteria.edit', [
            'title' => 'Admin Edit Kriteria',
            'kriteria' => $kriteria,
            'departments' => $departments,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKriteriaRequest $request, Kriteria $kriteria)
    {
        $prepareData = $request->except('image');

        if ($request->hasFile('image')) {
            if ($kriteria->image) {
                Storage::disk('public')->delete($kriteria->image);
            }
            $imagePath = $request->file('image')->store('kriteria', 'public');
            $prepareData['image'] = $imagePath;
        }

        $kriteria->update($prepareData);

        return redirect()->route('superadmin.kriteria.index')->with('success', 'Kriteria berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kriteria $kriteria)
    {
        if ($kriteria->image && $kriteria->image !== 'kriteria/default-kriteria.svg') {
            Storage::disk('public')->delete($kriteria->image);
        }

        $kriteria->delete();

        return redirect()->route('superadmin.kriteria.index')->with('success', 'Kriteria berhasil dihapus!');
    }
}

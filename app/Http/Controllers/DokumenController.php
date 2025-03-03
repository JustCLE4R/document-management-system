<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Kriteria;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokumenController extends Controller
{
    public function getDokumen(Request $request)
    {
        $kriteriaId = $request->query('kriteria');
        $kriteria = Kriteria::find($kriteriaId);

        if ((!$kriteria && $kriteriaId) || (Auth::user()->role != 'superadmin' && $kriteria && $kriteria->department_id && $kriteria->department_id != Auth::user()->department_id)) {
            return redirect('/')->with('error', 'Kriteria tidak ditemukan atau tidak sesuai dengan departemen pengguna');
        }

        $term = $request->input('result');
        $tipe = $request->input('tipe');
        $department = $request->input('department');

        $h2 = $kriteria ? $kriteria->name : 'Semua Dokumen';

        $dokumens = $this->search($term, $kriteriaId, $tipe, $department, 10);
        $departments = Department::orderByRaw("CASE WHEN parent_id IS NULL THEN id ELSE parent_id END, parent_id IS NOT NULL, name")->get();
        if (Auth::user()->role == 'superadmin') {
            $kriterias = Kriteria::all();
        } else {
            $kriterias = Kriteria::where('department_id', Auth::user()->department_id)
            ->orWhereNull('department_id')
            ->get();
        }

        return view('dokumen.index', [
            'title' => 'Daftar Dokumen',
            'h2' => $h2,
            'dokumens' => $dokumens,
            'departments' => $departments,
            'kriterias' => $kriterias,
        ]);
    }

    public function search(string $term = null, string $kriteria = null, string $tipe = null, string $department = null, int $paginate = 6) : object
    {
        $query = Dokumen::with(['kriteria', 'user.department'])->newQuery();

        if ($term) {
            $query->where(function ($query) use ($term) {
            $query->where('name', 'like', '%' . $term . '%')
                ->orWhere('sub_kriteria', 'like', '%' . $term . '%')
                ->orWhere('catatan', 'like', '%' . $term . '%');
            });
        }

        if ($kriteria) {
            $query->where('kriteria_id', $kriteria);
        }

        if ($tipe) {
            $query->where('tipe', $tipe);
        }

        if ($department && Auth::user()->role == 'superadmin') {
            $query->whereHas('user.department', function ($query) use ($department) {
                $query->where('id', $department);
            });
        } elseif (Auth::user()->role != 'superadmin') {
            $query->whereHas('user.department', function ($query) {
                $query->where('id', Auth::user()->department->id);
            });
        }

        $query->orderByDesc('created_at');

        $results = $query->paginate($paginate)->appends(request()->query());

        return $results;
    }

    public function show(Dokumen $dokumen)
    {
        $dokumen->increment('views');

        if ($dokumen->tipe === 'URL') {
            return redirect()->away($dokumen->path); // Redirect to external link
        }

        if ($dokumen->tipe === 'PDF' || $dokumen->tipe === 'Image') {
            return redirect(asset('storage/' . $dokumen->path)); // Open file directly
        }

        return response()->download(storage_path('app/public/' . $dokumen->path)); // Force download for other files
    }

    // public function download(Dokumen $dokumen)
    // {
    //     $dokumen->increment('downloads');

    //     return response()->download(storage_path('app/public/' . $dokumen->path));
    // }
}

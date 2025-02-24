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

        if (!$kriteria && $kriteriaId) {
            return redirect('/')->with('error', 'Kriteria tidak ditemukan');
        }

        $term = $request->input('result');
        $tipe = $request->input('tipe');
        $department = $request->input('department');

        $h2 = $kriteria ? $kriteria->name : 'Semua Dokumen';

        $dokumens = $this->search($term, $kriteriaId, $tipe, $department, 10);
        $departments = Department::where('id', '>', 1)->orderBy('name', 'asc')->get();
        $kriterias = Kriteria::all();

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
        $query = Dokumen::query();

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
            $query->whereHas('user.department', function ($query ) use ($department) {
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
}

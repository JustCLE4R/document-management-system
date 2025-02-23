<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokumenController extends Controller
{
    public function getDokumen(Request $request)
    {
        $kriteria = $request->query('kriteria');
        if (!in_array($kriteria, ['', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12])) {
            return redirect('/')->with('error', 'Kriteria tidak ditemukan');
        }
        $term = $request->input('result');
        $tipe = $request->input('tipe');
        $prodi = $request->input('prodi');

        $h2s = [
            '' => 'Semua Dokumen',
            1 => 'Kriteria 1',
            2 => 'Kriteria 2',
            3 => 'Kriteria 3',
            4 => 'Kriteria 4',
            5 => 'Kriteria 5',
            6 => 'Kriteria 6',
            7 => 'Kriteria 7',
            8 => 'Kriteria 8',
            9 => 'Kriteria 9',
            10 => 'Kondisi Eksternal',
            11 => 'Profil Institusi',
            12 => 'Analisis & Penetapan Program Pengembangan',
        ];
        $h2 = $h2s[$kriteria];

        $dokumens = $this->search($term, $kriteria, $tipe, $prodi, 10);
        $prodis = ProgramStudi::where('id', '>', 1)->orderBy('nama', 'asc')->get();

        return view('dokumen.index', [
            'title' => 'Daftar Dokumen',
            'h2' => $h2,
            'dokumens' => $dokumens,
            'prodis' => $prodis,
        ]);
    }

    public function search(string $term = null, string $kriteria = null, string $tipe = null, string $prodi = null, int $paginate = 6) : object
    {
        $query = Dokumen::query();

        if ($term) {
            $query->where(function ($query) use ($term) {
            $query->where('nama', 'like', '%' . $term . '%')
                ->orWhere('sub_kriteria', 'like', '%' . $term . '%')
                ->orWhere('catatan', 'like', '%' . $term . '%');
            });
        }

        if ($kriteria) {
            $query->where('kriteria', $kriteria);
        }

        if ($tipe) {
            $query->where('tipe', $tipe);
        }

        if ($prodi && Auth::user()->role == 'superadmin') {
            $query->whereHas('user.programStudi', function ($query ) use ($prodi) {
                $query->where('id', $prodi);
            });
        } elseif (Auth::user()->role != 'superadmin') {
            $query->whereHas('user.programStudi', function ($query) {
                $query->where('id', Auth::user()->programStudi->id);
            });
        }

        $query->orderByDesc('created_at');

        $results = $query->paginate($paginate)->appends(request()->query());

        return $results;
    }
}

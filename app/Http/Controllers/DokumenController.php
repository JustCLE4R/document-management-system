<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Kategori;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokumenController extends Controller
{
    public function getDokumen(Request $request)
    {
        $kategoriId = $request->query('kategori');
        $kategori = Kategori::find($kategoriId);

        if ((!$kategori && $kategoriId) || (Auth::user()->role != 'superadmin' && $kategori && $kategori->department_id && $kategori->department_id != Auth::user()->department_id)) {
            return redirect('/')->with('error', 'Kategori tidak ditemukan atau tidak sesuai dengan departemen pengguna');
        }

        $term = $request->input('result');
        $tipe = $request->input('tipe');
        $department = $request->input('department');

        $h2 = $kategori ? $kategori->name : 'Semua Dokumen';

        $dokumens = $this->search($term, $kategoriId, $tipe, $department, 10);
        $departments = Department::orderByRaw("CASE WHEN parent_id IS NULL THEN id ELSE parent_id END, parent_id IS NOT NULL, name")->get();
        if (Auth::user()->role == 'superadmin') {
            $kategoris = Kategori::all();
        } else {
            $kategoris = Kategori::where('department_id', Auth::user()->department_id)
            ->orWhereNull('department_id')
            ->get();
        }

        return view('dokumen.index', [
            'title' => 'Daftar Dokumen',
            'h2' => $h2,
            'dokumens' => $dokumens,
            'departments' => $departments,
            'kategoris' => $kategoris,
        ]);
    }

    public function search(string $term = null, string $kategori = null, string $tipe = null, string $department = null, int $paginate = 6) : object
    {
        $query = Dokumen::with(['kategori', 'user.department'])->newQuery();

        if ($term) {
            $query->where(function ($query) use ($term) {
            $query->where('name', 'like', '%' . $term . '%')
                ->orWhere('sub_kategori', 'like', '%' . $term . '%')
                ->orWhere('catatan', 'like', '%' . $term . '%');
            });
        }

        if ($kategori) {
            $query->where('kategori_id', $kategori);
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

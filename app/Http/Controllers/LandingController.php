<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Kategori;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index(){
        $facultyCount = Department::where('type', 'faculty')->count();
        $programtCount = Department::where('type', 'program')->count();
        $kategoriCount = Kategori::query();
        $dokumenCount = Dokumen::query();
        $departments = Department::orderByRaw("CASE WHEN parent_id IS NULL THEN id ELSE parent_id END, parent_id IS NOT NULL, name")->get();

        if (Auth::user()->role == 'superadmin') {
            $kategoris = Kategori::all();
        } else {
            $kategoris = Kategori::where(function ($query) {
            $query->where('department_id', Auth::user()->department->id)
                ->orWhereNull('department_id');
            })->get();
        }

        if (Auth::user()->role == 'superadmin') {
            $kategoriCount = $kategoriCount->count();
            $dokumenCount = $dokumenCount->count();
        } else {
            $kategoriCount = $kategoriCount->where('department_id', Auth::user()->department->id)->orWhere('department_id', 1)->count();
            $dokumenCount = $dokumenCount->whereHas('user.department', function ($query) {
                $query->where('id', Auth::user()->department->id);
            })->count();
        }

        return view('index', [
            'facultyCount' => $facultyCount,
            'programtCount' => $programtCount,
            'kategoriCount' => $kategoriCount,
            'dokumenCount' => $dokumenCount,
            'departments' => $departments,
            'kategoris' => $kategoris,
        ]);
    }
}

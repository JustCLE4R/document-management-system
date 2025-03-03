<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Kriteria;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index(){
        $facultyCount = Department::where('type', 'faculty')->count();
        $programtCount = Department::where('type', 'program')->count();
        $kriteriaCount = Kriteria::query();
        $dokumenCount = Dokumen::query();
        $departments = Department::orderByRaw("CASE WHEN parent_id IS NULL THEN id ELSE parent_id END, parent_id IS NOT NULL, name")->get();

        if (Auth::user()->role == 'superadmin') {
            $kriterias = Kriteria::all();
        } else {
            $kriterias = Kriteria::where(function ($query) {
            $query->where('department_id', Auth::user()->department->id)
                ->orWhereNull('department_id');
            })->get();
        }

        if (Auth::user()->role == 'superadmin') {
            $kriteriaCount = $kriteriaCount->count();
            $dokumenCount = $dokumenCount->count();
        } else {
            $kriteriaCount = $kriteriaCount->where('department_id', Auth::user()->department->id)->orWhere('department_id', 1)->count();
            $dokumenCount = $dokumenCount->whereHas('user.department', function ($query) {
                $query->where('id', Auth::user()->department->id);
            })->count();
        }

        return view('index', [
            'facultyCount' => $facultyCount,
            'programtCount' => $programtCount,
            'kriteriaCount' => $kriteriaCount,
            'dokumenCount' => $dokumenCount,
            'departments' => $departments,
            'kriterias' => $kriterias,
        ]);
    }
}

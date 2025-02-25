<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Kriteria;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index(){
        $dokumenCount = Dokumen::query();
        $departments = Department::where('id', '>', 1)->get();
        if (Auth::user()->role == 'superadmin') {
            $kriterias = Kriteria::all();
        } else {
            $kriterias = Kriteria::where(function ($query) {
            $query->where('department_id', Auth::user()->department->id)
                ->orWhereNull('department_id');
            })->get();
        }

        if (Auth::user()->role == 'superadmin') {
            $dokumenCount = $dokumenCount->count();
        } else {
            $dokumenCount = $dokumenCount->whereHas('user.department', function ($query) {
                $query->where('id', Auth::user()->department->id);
            })->count();
        }

        return view('index', [
            'dokumenCount' => $dokumenCount,
            'departments' => $departments,
            'kriterias' => $kriterias,
        ]);
    }
}

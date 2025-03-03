<?php

namespace App\Http\Controllers\superadmin;

use App\Models\Dokumen;
use App\Models\Kriteria;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatistikController extends Controller
{
    public function index()
    {
        $totalKriteria = Kriteria::count();
        $totalDepartment = Department::count();

        return view('superadmin.statistik.index',[
            'totalDocuments' => Dokumen::totalDocuments(),
            'totalKriteria' => $totalKriteria,
            'totalDepartment' => $totalDepartment,
            'newDocumentsToday' => Dokumen::newDocuments('day'),
            'newDocumentsWeek' => Dokumen::newDocuments('week'),
            'newDocumentsMonth' => Dokumen::newDocuments('month'),
            'mostViewedDocuments' => Dokumen::mostViewedDocuments(),
            'mostRevisedDocuments' => Dokumen::mostRevisedDocuments(),
            'mostRecentDocuments' => Dokumen::mostRecentDocuments(10),
            'documentsByKriteria' => Dokumen::documentsByKriteria(),
            'documentByDepartment' => Dokumen::documentByDepartment(),
            'documentsPerYear' => Dokumen::documentsPerYear(),
            'documentsPerMonth' => Dokumen::documentsPerMonth(),
            'documentsPerDay' => Dokumen::documentsPerDay(),
        ]);
    }
}

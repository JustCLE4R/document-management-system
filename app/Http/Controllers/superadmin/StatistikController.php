<?php

namespace App\Http\Controllers\superadmin;

use App\Models\Dokumen;
use App\Models\Kategori;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatistikController extends Controller
{
    public function index()
    {
        $totalKategori = Kategori::count();
        $totalDepartment = Department::count();

        return view('superadmin.statistik.index',[
            'title' => 'Statistik',
            'totalDocuments' => Dokumen::totalDocuments(),
            'totalKategori' => $totalKategori,
            'totalDepartment' => $totalDepartment,
            'newDocumentsToday' => Dokumen::newDocuments('day'),
            'newDocumentsWeek' => Dokumen::newDocuments('week'),
            'newDocumentsMonth' => Dokumen::newDocuments('month'),
            'mostViewedDocuments' => Dokumen::mostViewedDocuments(),
            'mostRevisedDocuments' => Dokumen::mostRevisedDocuments(),
            'mostRecentDocuments' => Dokumen::mostRecentDocuments(10),
            'documentsByKategori' => Dokumen::documentsByKategori(),
            'documentByDepartment' => Dokumen::documentByDepartment(),
            'documentsPerYear' => Dokumen::documentsPerYear(),
            'documentsPerMonth' => Dokumen::documentsPerMonth(),
            'documentsPerDay' => Dokumen::documentsPerDay(),
        ]);
    }
}

<?php

namespace App\Http\Controllers\superadmin;

use App\Models\Dokumen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatistikController extends Controller
{
    public function index()
    {
        return view('superadmin.statistik.index',[
            'totalDocuments' => Dokumen::totalDocuments(),
            'newDocumentsToday' => Dokumen::newDocuments('day'),
            'newDocumentsWeek' => Dokumen::newDocuments('week'),
            'newDocumentsMonth' => Dokumen::newDocuments('month'),
            'mostViewedDocuments' => Dokumen::mostViewedDocuments(),
            'mostRevisedDocuments' => Dokumen::mostRevisedDocuments(),
            'mostRecentDocuments' => Dokumen::mostRecentDocuments(20),
            'documentsByKriteria' => Dokumen::documentsByKriteria(),
            'documentByDepartment' => Dokumen::documentByDepartment(),
            'documentsPerYear' => Dokumen::documentsPerYear(),
            'documentsPerMonth' => Dokumen::documentsPerMonth(),
            'documentsPerDay' => Dokumen::documentsPerDay(),
        ]);
    }
}

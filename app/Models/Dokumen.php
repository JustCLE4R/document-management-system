<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dokumen extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = [
        'user'
    ];

    public static function totalDocuments()
    {
        return self::count();
    }

    public static function newDocuments($period = 'day')
    {
        $query = self::query();
        if ($period == 'day') {
            return $query->whereDate('created_at', Carbon::today())->count();
        } elseif ($period == 'week') {
            return $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        } elseif ($period == 'month') {
            return $query->whereYear('created_at', Carbon::now()->year)
                        ->whereMonth('created_at', Carbon::now()->month)
                        ->count();
        }
        return 0;
    }

    public static function documentsPerYear()
    {
        return self::selectRaw('YEAR(created_at) as year, count(*) as total')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();
    }

    public static function documentsPerMonth()
    {
        return self::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, count(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
    }

    public static function documentsPerDay()
    {
        return self::selectRaw('DATE(created_at) as day, count(*) as total')
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get();
    }

    public static function mostViewedDocuments($limit = 5)
    {
        return self::orderByDesc('views')->take($limit)->get(['name', 'views']);
    }

    public static function mostRevisedDocuments($limit = 5)
    {
        return self::orderByDesc('revisions')->take($limit)->get(['name', 'revisions']);
    }

    public static function mostRecentDocuments($limit = 5)
    {
        return self::with(['user.department', 'kriteria.department'])->orderByDesc('created_at')->take($limit)->get();
    }

    public static function documentsByKriteria($limit = 5)
    {
        return self::selectRaw('kriteria_id, count(*) as total')
            ->with(['kriteria:id,name,department_id', 'kriteria.department:id,name'])
            ->groupBy('kriteria_id')
            ->orderByDesc('total')
            ->take($limit)
            ->get();
    }

    public static function documentByDepartment($limit = 5)
    {
        return self::selectRaw('departments.name as department_name, count(*) as total')
            ->join('users', 'dokumens.user_id', '=', 'users.id')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->groupBy('departments.name')
            ->orderByDesc('total')
            ->take($limit)
            ->get();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}

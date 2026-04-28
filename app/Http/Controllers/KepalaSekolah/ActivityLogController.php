<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('causer', 'subject')
            ->latest();

        // Filter by causer (user)
        if ($request->causer) {
            $query->where('causer_id', $request->causer)
                  ->where('causer_type', 'App\Models\User');
        }

        // Filter by subject type
        if ($request->subject) {
            $query->where('subject_type', 'like', '%' . $request->subject . '%');
        }

        // Filter by tanggal
        if ($request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $activities = $query->paginate(20);

        // Ambil semua causer unik buat filter dropdown
        $causers = Activity::with('causer')
            ->whereNotNull('causer_id')
            ->get()
            ->pluck('causer')
            ->filter()
            ->unique('id')
            ->values();

        // Subject types unik buat filter
        $subjectTypes = Activity::whereNotNull('subject_type')
            ->distinct()
            ->pluck('subject_type')
            ->map(fn($t) => class_basename($t))
            ->unique()
            ->values();

        return view('kepala-sekolah.activity-log.index', compact(
            'activities', 'causers', 'subjectTypes'
        ));
    }

    public function show($id)
    {
        $activity = Activity::with('causer', 'subject')->findOrFail($id);
        return view('kepala-sekolah.activity-log.show', compact('activity'));
    }

    public function destroy($id)
    {
        Activity::findOrFail($id)->delete();
        return back()->with('success', 'Log aktivitas berhasil dihapus!');
    }
}
<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Employe;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Absensi/Index');
    }

    /**
     * Datatables
     * return Datatables
     * @return \Illuminate\Http\Request $request
     */
    public function json()
    {
        $now = Carbon::now()->format('Y-m-d');

        DB::statement(DB::raw('set @rownum=0'));
        $attendance = Attendance::with('employe')->select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'attendances.*'
        ]);

        return Datatables::of($attendance)

            ->addColumn('url', function ($attendance) {
                $url = asset('storage/permission/' . $attendance->permission);
                return $url;
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $dari = Carbon::parse($request->date[0])->addDay()->format('Y-m-d');
        $sampai = Carbon::parse($request->date[1])->format('Y-m-d');
        $collection = collect(Attendance::with('employe')->with('employe.position')->whereBetween('attended_at', [$dari, $sampai])->get());
        $employe = $collection->groupBy('employe_id')->map(function ($row) {
            return [
                'employee' => $row,
                'masuk' => $row->whereNotNull('in')->count(),
                'ijin' => $row->whereNotNull('permission')->count(),
            ];
        });

        $pdf = PDF::loadView('report', ['employe' => $employe]);
        return $pdf->download($dari . ' sampai ' . $sampai . '.pdf');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

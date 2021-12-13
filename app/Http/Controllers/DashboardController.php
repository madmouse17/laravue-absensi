<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //chart absensi
        $now = Carbon::now()->format('Y');
        $month = [];
        $count = [];
        $permission = [];

        for ($m = 1; $m <= 12; $m++) {
            $month[] = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
            $count[] = Attendance::whereMonth('attended_at', $m)->whereYear('attended_at', $now)->whereNotNull('in')->count();
            $permission[] = Attendance::whereMonth('attended_at', $m)->whereYear('attended_at', $now)->whereNotNull('permission')->count();
        }

        //tabel absensi
        $date_now = Carbon::now()->format('Y-m-d');
        $absensi = Attendance::with('employe')->where('attended_at', $date_now)->latest()->take(5)->get();


        return Inertia::render('Admin/Dashboard', ['count' => $count, 'month' => $month, 'now' => $now, 'permission' => $permission, 'absensi' => $absensi]);
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
        //
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

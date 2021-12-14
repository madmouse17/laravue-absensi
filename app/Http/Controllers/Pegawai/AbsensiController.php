<?php

namespace App\Http\Controllers\Pegawai;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Employe;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Pegawai/Absensi');
    }

    /**
     * Datatables
     * return Datatables
     * @return \Illuminate\Http\Request $request
     */
    public function json()
    {
        $employe = Employe::where('user_id', Auth::id())->first();
        DB::statement(DB::raw('set @rownum=0'));
        $employes = Attendance::where('employe_id', $employe->id)->select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'attendances.*'
        ]);

        return Datatables::of($employes)
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

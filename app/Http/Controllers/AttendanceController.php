<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        Validator::make($request->all(), [
            'in' => 'required'
        ]);
        Attendance::create([
            'employe_id' => $request->employe_id,
            'attended_at' => Carbon::now()->format('Y-m-d'),
            'in' => Carbon::now()->format('H:i:s')
        ]);
    }
    public function out(Request $request)
    {
        $now = Carbon::now()->format('Y-m-d');
        $attend = Attendance::where('attended_at', $now)->where('employe_id', $request->employe_id)->first();

        $attend->update([
            'out' => Carbon::now()->format('H:i:s')
        ]);
    }

    public function permission(Request $request)
    {
        Validator::make($request->all(), [
            'attend' => 'required',
            'desc' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png|max:2000'
        ]);
        $profile_name = $request->file('image');
        $nama_file = time() . "_" . $profile_name->getClientOriginalName();
        Storage::putFileAs('public/permission/', $profile_name, $nama_file);
        foreach ($request->attend as $value) {
            Attendance::create([
                'employe_id' => $request->employe_id,
                'attended_at' => Carbon::parse($value)->format('y-m-d'),
                'permission' => $nama_file,
                'desc' => $request->desc,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}

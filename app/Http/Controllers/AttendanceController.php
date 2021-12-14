<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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
        $now = Carbon::now()->format('Y-m-d');
        $att = Attendance::where('attended_at', $now)->where('employe_id', $request->employe_id)->first();
        if ($att->attended_at == $now && $att->employe_id == $request->employe_id) {
            $att->update([
                'in' => Carbon::now()->format('H:i:s')
            ]);
        } else {
            Attendance::create([
                'employe_id' => $request->employe_id,
                'attended_at' => Carbon::now()->format('Y-m-d'),
                'in' => Carbon::now()->format('H:i:s')
            ]);
        }


        return Redirect::route('absensi.index')->with('message', 'Absen masuk Berhasil');
    }
    public function out(Request $request)
    {
        $now = Carbon::now()->format('Y-m-d');
        $attend = Attendance::where('attended_at', $now)->where('employe_id', $request->employe_id)->whereNotNull('in')->first();

        $attend->update([
            'out' => Carbon::now()->format('H:i:s')
        ]);
        return Redirect::route('absensi.index')->with('message', 'Absen pulang Berhasil');
    }

    public function permission(Request $request)
    {


        Validator::make($request->all(), [
            'attend' => 'required',
            'desc' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png|max:2000'
        ]);
        $profile_name = $request->file('image');
        $nama_file = time() . "_" . str_replace(' ', '', $profile_name->getClientOriginalName());
        $count = count($request->attend) - 1;
        $attend = $request->attend;
        $addDays = [1 => Carbon::parse($request->attend[1])->addDay($count)->format('Y-m-d')];
        $replace = array_replace($attend, $addDays);
        Storage::putFileAs('public/permission/', $profile_name, $nama_file);

        $now = Carbon::now()->format('Y-m-d');
        $att = Attendance::where('attended_at', $now)->where('employe_id', $request->employe_id)->first();

        foreach ($replace as $value) {

            if ($att->attended_at ==  Carbon::parse($value)->format('Y-m-d') && $att->employe_id == $request->employe_id) {

                $att->update([
                    'permission' => $nama_file,
                    'desc' => $request->desc,
                ]);
            } else {
                Attendance::create([
                    'permission' => $nama_file,
                    'desc' => $request->desc,
                    'employe_id' => $request->employe_id,
                    'attended_at' => Carbon::parse($value)->format('y-m-d'),
                ]);
            }
        }
        return Redirect::route('absensi.index')->with('message', 'Ijin Berhasil Dibuat');
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

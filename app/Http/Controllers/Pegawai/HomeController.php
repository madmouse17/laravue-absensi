<?php

namespace App\Http\Controllers\Pegawai;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Employe;
use App\Models\Location;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $image_url = Employe::get();
        $image = [];
        foreach ($image_url as  $value) {
            array_push($image, $value->image);
        }


        return Inertia::render('Pegawai/Index', ['image' => $image]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->image != '') {
            $presen = Employe::with('position')->where('image', $request->image)->first();
            $url =  asset('/storage/pegawai/' . $presen->image);
            $locate = Location::where('id', 1)->first();
            $now = Carbon::now()->format('Y-m-d');
            $attend = Attendance::where('attended_at', $now)->where('employe_id', $presen->id)->first();
            return Inertia::render('Pegawai/Create', ['presen' => $presen, 'url' => $url, 'locate' => $locate, 'attend' => $attend]);
        }
    }

    public function permission(Request $request)
    {
        $presen = Employe::where($request->presen_id)->first();
        return Inertia::render('Pegawai/Permission', [
            'presen' => $presen
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

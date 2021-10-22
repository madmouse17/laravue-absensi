<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Employe;
use App\Models\Position;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Employe/Index');
    }

    /**
     * Datatables
     * return Datatables
     * @return \Illuminate\Http\Request $request
     */
    public function json()
    {

        DB::statement(DB::raw('set @rownum=0'));
        $employes = Employe::with('user')->with('position')->select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'employes.*'
        ]);

        return Datatables::of($employes)
            ->editColumn('created_at', function ($employes) {
                if ($employes->created_at != null) {
                    return $employes->created_at->format('d-M-Y');
                }
            })
            ->addColumn('url', function ($employes) {
                $url = asset('storage/pegawai/' . $employes->image);
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
        $employe = Employe::get();
        $user_id = [];
        $filter = $employe->filter(function ($value, $key) {
            return $value->user_id != null;
        });
        foreach ($filter as $value) {
            array_push($user_id, $value->user_id);
        }
        $user = User::whereNotIn('id', $user_id)->get();
        $position = Position::get();
        return Inertia::render('Admin/Employe/Create', ['user' => $user, 'position' => $position]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->all()) {
            $request->validate([
                'name' => 'required',
                'position_id' => 'required',
                'gender' => 'required',
                'birthdate' => 'required',
                'image' => 'required|mimes:jpg,jpeg,png,webp,svg|max:2000',
                'nip' => 'required'
            ]);
            $profile_name = $request->file('image');
            $nama_file = time() . "_" . str_replace(' ', '', $profile_name->getClientOriginalName());
            Storage::putFileAs('public/pegawai/', $profile_name, $nama_file);
            if ($request->user_id) {
                Employe::create([
                    'name' => $request->name,
                    'position_id' => $request->position_id['id'],
                    'user_id' => $request->user_id['id'],
                    'gender' => $request->gender,
                    'birthdate' => Carbon::parse($request->birthdate)->format('y-m-d'),
                    'image' => $nama_file,
                    'nip' => $request->nip
                ]);
            } else {
                Employe::create([
                    'name' => $request->name,
                    'position_id' => $request->position_id['id'],
                    'gender' => $request->gender,
                    'birthdate' => Carbon::parse($request->birthdate)->format('y-m-d'),
                    'image' => $nama_file,
                    'nip' => $request->nip
                ]);
            }
            return Redirect::route('employe.index')->with('message', 'Pegawai ' . $request->name . ' Berhasil Dibuat');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function show(Employe $employe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function edit(Employe $employe)
    {
        $user = User::get();
        $position = Position::get();
        $selected_user = $employe->user()->first();
        $selected_position = $employe->position()->first();
        $url_image = asset('storage/pegawai/' . $employe->image);
        return Inertia::render('Admin/Employe/Edit', ['employe' => $employe, 'user' => $user, 'position' => $position, 'selected_user' => $selected_user, 'selected_position' => $selected_position, 'url_image' => $url_image]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employe $employe)
    {
        if ($request->file('image') != '') {
            $oldFilename = $employe->image;
            Storage::delete('public/pegawai/' . $oldFilename);
            $request->validate([
                'name' => 'required',
                'position_id' => 'required',
                'gender' => 'required',
                'birthdate' => 'required',
                'image' => 'required|mimes:jpg,jpeg,png,webp,svg|max:2000',
                'nip' => 'required'
            ]);
            $profile_name = $request->file('image');
            $nama_file = time() . "_" . str_replace(' ', '', $profile_name->getClientOriginalName());
            Storage::putFileAs('public/pegawai/', $profile_name, $nama_file);
            if ($request->user_id) {
                $employe->update([
                    'name' => $request->name,
                    'position_id' => $request->position_id['id'],
                    'user_id' => $request->user_id['id'],
                    'gender' => $request->gender,
                    'birthdate' => Carbon::parse($request->birthdate)->format('y-m-d'),
                    'image' => $nama_file,
                    'nip' => $request->nip
                ]);
            } else {
                $employe->update([
                    'name' => $request->name,
                    'position_id' => $request->position_id['id'],
                    'gender' => $request->gender,
                    'birthdate' => Carbon::parse($request->birthdate)->format('y-m-d'),
                    'image' => $nama_file,
                    'nip' => $request->nip
                ]);
            }

            return Redirect::route('employe.index')->with('message', 'Pegawai ' . $request->name . ' Berhasil DiUbah');
        } else {
            $request->validate([
                'name' => 'required',
                'position_id' => 'required',
                'gender' => 'required',
                'birthdate' => 'required',
                'nip' => 'required'
            ]);
            if ($request->user_id) {
                $employe->update([
                    'name' => $request->name,
                    'position_id' => $request->position_id['id'],
                    'user_id' => $request->user_id['id'],
                    'gender' => $request->gender,
                    'birthdate' => Carbon::parse($request->birthdate)->format('y-m-d'),
                    'nip' => $request->nip
                ]);
            } else {
                $employe->update([
                    'name' => $request->name,
                    'position_id' => $request->position_id['id'],
                    'gender' => $request->gender,
                    'birthdate' => Carbon::parse($request->birthdate)->format('y-m-d'),
                    'nip' => $request->nip
                ]);
            }


            return Redirect::route('employe.index')->with('message', 'Pegawai ' . $request->name . ' Berhasil DiUbah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employe $employe)
    {
        Storage::delete('public/pegawai/' . $employe->image);
        $employe->delete();
        return Redirect::route('employe.index');
    }
    public function deleteAll($id)
    {
        $ids = explode(",", $id);
        $image = Employe::whereIn('id', $ids)->get();
        foreach ($image as $key => $value) {
            Storage::delete('public/pegawai/' . $value->image);
        };

        Employe::whereIn('id', $ids)->delete();
        return Redirect::route('employe.index');
    }
}

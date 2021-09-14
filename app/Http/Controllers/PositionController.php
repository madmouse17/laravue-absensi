<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Position/Index');
    }

    /**
     * Datatables
     * return Datatables
     */
    public function json()
    {

        DB::statement(DB::raw('set @rownum=0'));
        $positions = Position::select([
            DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'name',
            'gaji',
            'created_at',
        ]);

        return Datatables::of($positions)
            ->editColumn('created_at', function ($positions) {
                if ($positions->created_at != null) {
                    return $positions->created_at->format('d-M-Y');
                }
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
        Validator::make($request->all(), [
            'name' => 'required|string|unique:positions',
            'gaji' => 'required|numeric',
        ]);

        Position::create([
            'name' => $request->name,
            'gaji' => $request->gaji
        ]);

        return Redirect::route('position.index')->with('message', 'Jabatan ' . $request->name . ' Berhasil Dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
        Validator::make($request->all(), [
            'name' => ['required', Rule::unique('positions', 'name')
                ->ignore($position->id)],
            'gaji' =>   'required|numeric',
        ]);

        $position->update([
            'name' => $request->name,
            'gaji' => $request->gaji
        ]);
        return Redirect::route('position.index')->with('message', 'Jabatan ' . $position->name . ' Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        $position->delete();

        return Redirect::route('position.index');
    }
    public function deleteAll($id)
    {
        $ids = explode(",", $id);
        Position::whereIn('id', $ids)->delete();
        return Redirect::route('position.index');
    }
}

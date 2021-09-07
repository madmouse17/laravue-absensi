<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render("Admin/User/Index");
    }

    /**
     * Datatables
     * return Datatables
     * @return \Illuminate\Http\Request $request
     */
    public function json(Request $request)
    {
        if ($request->ajax()) {
            DB::statement(DB::raw('set @rownum=0'));
            $users = User::select([
                DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'id',
                'name',
                'email',
                'created_at',
            ]);

            return Datatables::of($users)
                ->editColumn('created_at', function ($users) {
                    if ($users->created_at != null) {
                        return $users->created_at->format('d-M-Y');
                    }
                })
                ->editColumn('action', function ($users) {
                    return view('yajra_buttons', ['id' => $users->id])->render();
                })
                ->make(true);
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Admin/User/Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        //    return Inertia::render("Admin/User/Index", $user);
        return Redirect::route('user.index')->with('message', 'User ' . $request->name . ' Berhasil Dibuat');
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
    public function edit($user)
    {
        $users = User::findorFail($user);
        return Inertia::render("Admin/User/Edit", ['user' => $users]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user)
    {
        $update = User::FindorFail($user);
        if ($request->password == '') {
            // $request->validate([
            //     'name' => 'required|string|max:255',
            //     'email' => 'required|string|email|max:255|unique:users' . $update->id,
            // ]); 
            Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => [Rule::unique('users', 'email')
                    ->ignore($update->id)],
            ]);

            $update->update([
                'name' => $request->name,
                'email' => $request->email
            ]);
        } else {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);
            $update->update($request->all);
        }

        return Redirect::route('user.index')->with('message', 'User ' . $update->name . ' Berhasil Diupdate');
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

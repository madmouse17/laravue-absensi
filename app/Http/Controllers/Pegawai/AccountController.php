<?php

namespace App\Http\Controllers\Pegawai;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Employe;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employe = Employe::where('user_id', Auth::user()->id)->with('position')->with('user')->first();
        $url =  asset('/storage/pegawai/' . $employe->image);
        return Inertia::render('Pegawai/Account', ['employe' => $employe, 'url' => $url]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Pegawai/ChangePass');
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
            'password_lama' => ['required', new MatchOldPassword],
            'password_baru' => ['required', 'min:8'],
            'confirm_password_baru' => ['same:password_baru'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->password_baru)]);

        return Redirect::route('presensi.index')->with('message',   'Password Berhasil Diupdate');
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
        $user = User::whereId($id)->first();
        Validator::make($request->all(), [
            'email' => ['required|email', Rule::unique('users', 'email')
                ->ignore($user->id)],
        ]);
        $user->update([
            'email' => $request->email
        ]);
        return Redirect::route('presensi.index')->with('message',   'Email Berhasil Diupdate');
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

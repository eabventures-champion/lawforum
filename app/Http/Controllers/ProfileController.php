<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

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
    public function edit(User $user)
    {
        $user = Auth::user();
        return view('user_dashboard.profile', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        //
        if(Auth::user()->email == request('email')) {
        
            $this->validate(request(), [
                    'name' => ['required', 'string', 'max:255'],
                    'lname' => ['required', 'string', 'max:255'],
                    'phone' => ['nullable','numeric', 'digits_between:10,14'],
                    'country' => ['nullable', 'string', 'max:255'],
                //  'email' => 'required|email|unique:users',
                    // 'password' => 'required|min:6|confirmed'
                ]);

                $user->name = request('name');
                $user->lname = request('lname');
                $user->phone = request('phone');
                $user->country = request('country');
            // $user->email = request('email');
                // $user->password = bcrypt(request('password'));

                $user->save();

                return back()->with('updated','Your Profile information has been saved successfully!');
            }
        else{
            $this->validate(request(), [
                    'name' => ['required', 'string', 'max:255'],
                    'lname' => ['required', 'string', 'max:255'],
                    'phone' => ['nullable','numeric', 'digits_between:10,14'],
                    'country' => ['nullable', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    // 'password' => 'required|min:6|confirmed'
                ]);

                $user->name = request('name');
                $user->lname = request('lname');
                $user->phone = request('phone');
                $user->country = request('country');
                $user->email = request('email');
                // $user->password = bcrypt(request('password'));

                $user->save();

                return back()->with('updated','Your Profile information has been saved successfully!');
                }
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

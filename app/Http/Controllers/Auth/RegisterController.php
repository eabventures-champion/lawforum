<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        if (isset($data['country']) && $data['country'] === 'Ghana') {
            $rules['phone'] = ['required', 'numeric', 'digits:10', 'unique:users'];
        } else {
            $rules['phone'] = ['required', 'numeric', 'digits_between:10,14', 'unique:users'];
        }

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'lname' => $data['lname'],
            'country' => $data['country'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password'])
        ]);

        \App\AdminNotification::create([
            'type' => 'signup',
            'data' => [
                'user_id' => $user->id,
                'name' => $user->name . ' ' . $user->lname,
                'email' => $user->email,
                'country' => $user->country
            ]
        ]);

        return $user;
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(\Illuminate\Http\Request $request, $user)
    {
        session()->flash('new_registration', true);
        return redirect('/email/verify');
    }

    public function checkDuplicate(\Illuminate\Http\Request $request)
    {
        $email = $request->input('email');
        $phone = $request->input('phone');
        
        $emailExists = false;
        $phoneExists = false;

        if ($email) {
            $emailExists = User::where('email', $email)->exists();
        }

        if ($phone) {
            $phoneExists = User::where('phone', $phone)->exists();
        }

        return response()->json([
            'email_taken' => $emailExists,
            'phone_taken' => $phoneExists
        ]);
    }
}

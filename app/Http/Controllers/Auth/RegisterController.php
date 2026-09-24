<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\ResearcherType;
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
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm(\Illuminate\Http\Request $request)
    {
        $role = $request->query('role', '');

        // Block registration if the role is disabled via admin settings
        $roleSettingMap = [
            'student' => 'student_registration_enabled',
            'lawyer' => 'lawyer_registration_enabled',
            'researcher' => 'researcher_registration_enabled',
        ];

        if (isset($roleSettingMap[$role])) {
            $enabled = \App\RegistrationSetting::get($roleSettingMap[$role], '1');
            if ($enabled !== '1') {
                return redirect()->route('get-started')
                    ->with('error', ucfirst($role) . ' registration is not currently available. Please check back later.');
            }
        }

        $researcherTypes = ResearcherType::active()->get();
        return view('auth.register', compact('role', 'researcherTypes'));
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

        // Validate researcher type when registering as researcher
        if (isset($data['user_type']) && $data['user_type'] === 'researcher') {
            $rules['researcher_type'] = ['required', 'string', 'max:255'];
            if (isset($data['researcher_type']) && $data['researcher_type'] === 'Other') {
                $rules['researcher_type_other'] = ['required', 'string', 'max:255'];
            }
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
            'password' => Hash::make($data['password']),
            'user_type' => $data['user_type'] ?? null,
            'researcher_type' => $data['researcher_type'] ?? null,
            'researcher_type_other' => $data['researcher_type_other'] ?? null,
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
        // Check if there is an active pending team invitation for this user
        $token = session('pending_team_invite_token');
        $invite = null;
        if ($token) {
            $invite = \App\SubscriptionTeamMember::where('invite_token', $token)->where('status', 'pending')->first();
        }
        if (!$invite && $user->email) {
            $invite = \App\SubscriptionTeamMember::where('email', strtolower($user->email))->where('status', 'pending')->first();
        }

        if ($invite) {
            $invite->update([
                'member_id' => $user->id,
                'status' => 'accepted',
                'accepted_at' => now(),
            ]);
            session()->forget(['pending_team_invite_token', 'pending_team_invite_email']);

            return redirect()->route('team.index')->with('status', 'Congratulations! Your account has been created and you have joined the collaborative research team workspace.');
        }

        session()->flash('new_registration', true);
        return redirect()->route('register.choose-plan');
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

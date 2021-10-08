<?php

namespace App\Http\Controllers;

use App\Http\Traits\ImageTrait;
use App\Http\Traits\PermissionTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use PermissionTrait, ImageTrait;

    public function checkEmail(Request $request)
    {
        $email = User::where('email', $request->input('email'))->first();
        if ($email) {
            return response([
                'message' => 'Email Registered'
            ], 400);
        }

        return response([
            'meesage' => 'Email Not Registered'
        ], 200);
    }

    public function getProfilePicture($id)
    {
        $user = User::get()->find($id);
        return response()->file(storage_path('/app/profile_pictures/' . $user->profile_picture));
    }

    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|string|confirmed|min:8|max:20|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'phone_number' => 'required|string',
            'profile_picture' => 'image|mimes:jpeg,png,jpg'
        ]);

        $fields['location'] = 'unlocated';
        $fields['user_status'] = 'Unconfirmed';
        $fields['password'] = bcrypt($fields['password']);
        $user = User::create($fields);

        if ($request->hasFile('profile_picture')) {
            $user->profile_picture = $this->saveImages('users', $user->id, $request->file('profile_picture'));
            $user->save();
        }
        $this->changeRole($user, 'Non Aktif')->implode('');

        $data = [
            'name' => $user->name,
        ];

        Mail::send('emails.registered', $data, function ($message) use ($user) {
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $message->to($user->email, $user->name);
            $message->subject('Register');
        });

        if (Mail::failures()) {
            return response([
                'message' => 'Email Error.'
            ], 400);
        }

        $response = [
            'message' => 'User Created',
            'user' => $user,
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $fields['email'])->first();
        if ($user && $fields['password'] == $user->remember_token) {
            return response([
                'message' => 'Reset Password'
            ], 200);
        }
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad Credentials.',
            ], 400);
        }


        if ($this->checkPermission($user, 'web-login') == true || $this->checkPermission($user, 'mobile-login') == true) {
            $user->remember_token = NULL;
            $user->save();
            if ($this->checkPermission($user, 'mobile-dashboard-nongraph') == true) {
                $user->type = "External";
            } else {
                $user->type = "Internal";
            }

            $token = $user->createToken('yodaapps-token')->plainTextToken;


            $response = [
                'message' => 'Success',
                'user' => $user,
                'token' => $token
            ];

            return response($response, 200);
        }

        return response([
            'message' => 'Unauthorized.'
        ], 403);
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
        return [
            'message' => 'Logged out'
        ];
    }
    public function userManagement(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'user-management-access') == false) {
            return response([
                'message' => 'Unauthorized.'
            ], 403);
        }

        $fields = $request->validate([
            'target_email' => 'required|email',
            'user_status' => 'required|string',
            'role' => 'required|string',
            'location' => 'required|string'
        ]);

        $user = User::where('email', $fields['target_email'])->first();
        $role = Role::where('name', $fields['role'])->first();
        if (!$user) {
            return response([[
                'message' => 'User Not Found.',
            ]], 400);
        }
        if (!$role) {
            return response([[
                'message' => 'Role Not Found.',
            ]], 400);
        }

        $user->user_status = $fields['user_status'];
        $user->location = $fields['location'];
        $user->save();

        if ($fields['user_status'] == 'Tidak Aktif' || $fields['user_status'] == 'Rejected') {
            $user->role =  $this->changeRole($user, 'Non Aktif')->implode('');
        } else {
            $user->role =  $this->changeRole($user, $fields['role'])->implode('');
        }
        $response = [
            'message' => 'Success',
            'user' => $user,
        ];

        return response($response, 200);
    }

    public function forgot(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return response([
                'message' => 'User Not Found.'
            ], 400);
        }

        $token = Str::random(12);
        $user->remember_token = $token;
        $user->save();
        $data = [
            'name' => $user->name,
            'temp_password' => $user->remember_token
        ];

        Mail::send('emails.mail', $data, function ($message) use ($user) {
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $message->to($user->email, $user->name);
            $message->subject('Reset Password');
        });

        if (Mail::failures()) {
            return response([
                'message' => 'Email Error.'
            ], 400);
        }

        return response([
            'message' => 'Reset Password Email sent.',
            'temp_password' => $user->remember_token
        ], 200);
    }

    public function reset(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:8|max:20|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return response([
                'message' => 'User Not Found.'
            ], 400);
        }

        $user->password = bcrypt($credentials['password']);
        $user->remember_token = NULL;
        $user->save();

        return response([
            'message' => 'Password Successfully Changed'
        ], 200);
    }

    public function profile()
    {
        $user = auth()->user();
        $roles = auth()->user()->getRoleNames();
        $user->role = $roles->pluck('name');
        return $user;
    }

    public function index()
    {
        $users = User::get();

        foreach ($users as $user) {
            $roles = $user->roles->pluck('name')->toArray();
            $user->role = $roles[0];

            unset($user->roles);
        }
        return response([
            'users' => $users
        ], 200);
    }

    public function updateNamaEmail(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'user-management-access') == false) {
            return response([
                'message' => 'Unauthorized.'
            ], 403);
        }

        $fields = $request->validate([
            'id' => 'required',
            'name' => 'required|string',
            'email' => 'required|email',
        ]);
        $id = $request->input('id');
        $name = $request->input('name');
        $email = $request->input('email');
        $user = User::find($id);
        if ($user) {
            $user->name = $name;
            $user->email = $email;
            $user->save();

            return response([
                'message' => 'Success'
            ], 200);
        }
        return response([
            'message' => 'User not found'
        ], 400);
    }

    public function updateNoHP(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'user-management-access') == false) {
            return response([
                'message' => 'Unauthorized.'
            ], 403);
        }

        $fields = $request->validate([
            'id' => 'required',
            'phone_number' => 'required|string',
        ]);

        $id = $request->input('id');
        $phone_number = $request->input('phone_number');
        $user = User::find($id);
        if ($user) {
            $user->phone_number = $phone_number;
            $user->save();

            return response([
                'message' => 'Success'
            ], 200);
        }
        return response([
            'message' => 'User not found'
        ], 400);
    }

    public function updateKantor(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'user-management-access') == false) {
            return response([
                'message' => 'Unauthorized.'
            ], 403);
        }

        $fields = $request->validate([
            'id' => 'required',
            'location' => 'required|string',
        ]);

        $id = $request->input('id');
        $location = $request->input('location');
        $user = User::find($id);
        if ($user) {
            $user->location = $location;
            $user->save();

            return response([
                'message' => 'Success'
            ], 200);
        }
        return response([
            'message' => 'User not found'
        ], 400);
    }

    public function updateRole(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'user-management-access') == false) {
            return response([
                'message' => 'Unauthorized.'
            ], 403);
        }

        $fields = $request->validate([
            'id' => 'required',
            'role_name' => 'required|string',
        ]);

        $id = $request->input('id');
        $role_name = $request->input('role_name');
        $user = User::find($id);
        $role = Role::where('name', $role_name)->first();
        if (!$user) {
            return response([[
                'message' => 'User Not Found.',
            ]], 400);
        }
        if (!$role) {
            return response([[
                'message' => 'Role Not Found.',
            ]], 400);
        }

        $user->role =  $this->changeRole($user, $role_name)->implode('');
        return response([
            'message' => 'Success'
        ], 200);
    }

    public function updateStatus(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'user-management-access') == false) {
            return response([
                'message' => 'Unauthorized.'
            ], 403);
        }
        $fields = $request->validate([
            'id' => 'required',
            'user_status' => 'required|string',
        ]);

        $id = $request->input('id');
        $user_status = $request->input('user_status');
        $user = User::find($id);
        if ($user) {
            $user->user_status = $user_status;
            $user->save();

            return response([
                'message' => 'Success'
            ], 200);
        }
        return response([
            'message' => 'User not found'
        ], 400);
    }


    public function deleteRejected($id)
    {
        if ($this->checkPermission(auth()->user(), 'user-management-access') == false) {
            return response([
                'message' => 'Unauthorized.'
            ], 403);
        }

        $user = User::find($id);
        $role = $user->roles->pluck('name');
        if ($role[0] == 'Non Aktif' && $user->user_status == 'Rejected') {
            $user->delete();
            return response([
                'message' => 'Success'
            ], 200);
        }
        return response([
            'message' => 'User not found or User is not Rejected'
        ], 400);
    }

    public function gettokenss()
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true || $this->checkPermission(auth()->user(), 'nav-content-management-access') == true) {
            return 1;
        }

        return 0;
    }
}

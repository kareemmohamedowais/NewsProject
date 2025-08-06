<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;
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
    protected $redirectTo = '/home';

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
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string','unique:users', 'max:55'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:11','min:11','unique:users'],
            'country' => ['nullable', 'string', 'max:55'],
            'city' => ['nullable', 'string', 'max:55'],
            'street' => ['nullable', 'string', 'max:55'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'phone' => $data['phone'],
            'country' => $data['country'],
            'city' => $data['city'],
            'street' => $data['street'],
            'password' => Hash::make($data['password']),
        ]);

        if($data['image']){
            $file = $data['image'];
            $filename = Str::slug($user->username).time().$file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/users',$filename ,['disk'=>'uploads'] );

            $user->update([
                'image'=>$path,
            ]);
        }


        // if($data['image']){
        //     $file = $data['image'];
        //     $filename = Str::slug($user->username).time().$file->getClientOriginalExtension();

        //     $path = $file->storeAs('uploads/users',$filename,["disk"=>"uploads"]);

        //     $user->update([
        //         'image' =>$path,
        //     ]);
        // }
        return $user;

    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect($this->redirectPath());
    }
        protected function registered(Request $request, $user)
    {
        Session::flash('success','register  success');
        return redirect()->route('frontend.index');
    }
}

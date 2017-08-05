<?php

namespace App\Http\Controllers\Api\Internal\Auth;

use App\Models\Role_User;
use App\Models\Roles;
use App\Models\User;
use App\Repository\MJ\Auth\Role;
use App\Repository\MjInterface\AuthInterface;
use App\Repository\MjInterface\RoleInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(AuthInterface $auth, Request $request, RoleInterface $role)
    {

        //this->middleware('auth.prms:all|user-operate');
        $this->middleware('auth.prms:check|sss', ['except' => ['login', 'getLogin']]);
        //$this->middleware('auth', ['except' => ['login', 'getLogin']]);
        $this->role = $role;
        $this->auth = $auth;
        $this->request = $request;
    }


    public function getLogin()
    {
        return view('Admin.Index.Login');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     *
     */
    function login()
    {

       $ret =  DB::table('users')->where('id','>',0)->first()->toArray();
        var_export($ret);die;

        $fill_able = [
            'name' => 'required|max:10|min:2',
            'password' => 'required|max:12|min:6',

        ];
        $message = [
            'name.required' => 'User_Name Required',
            'password.required' => 'Password Required'
        ];
        $validator = Validator::make(Input::all(), $fill_able, $message);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }
        $data = $this->request->all();

        $ret = $this->auth->login($data);
        return $ret;
        return view('Admin.Index.Index', compact('ret'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $role_id = $request->get('role_id') ?: 3;
        $role_id = explode(',', $role_id);
        $user_name = $request->get('name');
        $password = $request->get('password');
        $user_info = ['name' => $user_name, 'password' => Hash::make($password)];
        $ret = User::create($user_info)->role()->saveMany(Roles::whereIn('id', $role_id)->get());
        return response()->success($ret);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user_id = $request->get('user_id');
        $role_id = $request->get('role_id') ?: 3;
        $role_id = explode(',', $role_id);
        $user_name = $request->get('name');
        $password = $request->get('password');
        $user_info = ['name' => $user_name, 'password' => Hash::make($password)];
        User::findOrFail($user_id)->role()->detach();
        $ret = User::findOrFail($user_id)->role()->attach($role_id);

        return response()->success($ret);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ret = User::destroy(explode(',', $id));
        return response()->success([$ret]);
    }

    public function logout()
    {
        $ret = $this->auth->logout();
        return $ret;
    }
}

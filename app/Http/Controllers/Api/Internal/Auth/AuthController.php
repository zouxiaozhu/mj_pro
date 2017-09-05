<?php

namespace App\Http\Controllers\Api\Internal\Auth;

use App\Http\Controllers\Api\Internal\CommonTrait;
use App\Models\Roles;
use App\Models\User;
use App\Repository\MjInterface\AuthInterface;
use App\Repository\MjInterface\RoleInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth as OAuth;
use Zhanglong\Wcc\Taxi;
use Zouxiaozhu\Zmedia\MediaService;

class AuthController extends Controller
{
    use CommonTrait;
    /**
     * Display a listing of the resource.
     *
     * @param AuthInterface $auth
     * @param Request       $request
     * @param RoleInterface $role
     */
    public function __construct(AuthInterface $auth, Request $request, RoleInterface $role)
    {
        //this->middleware('auth.prms:all|user-operate');
        $this->middleware('auth.prms:check|sss', ['except' => ['login', 'getLogin']]);
    }
    public function __construt(AuthInterface $auth, Request $request, RoleInterface $role)
    {
        $this->middleware('auth.prms:all|user-manage',['only'=>['create','update','destory']]);
        $this->role = $role;
        $this->auth = $auth;
    }

    /**
     * 登录
     */
    public function login(Request $request)
    {
echo app()->make(MediaService::class)->get();die;
        $fill_able = [
            'name' => 'required|max:10|min:2',
            'password' => 'required|max:12|min:6',
        ];
        $message = [
            'name.required' => 'User_Name Required',
            'password.required' => 'Password Required'
        ];

        $remember = $request->has('remember') ? intval($request->has('remember')) : 0;
        $validator = Validator::make(Input::all(), $fill_able, $message);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }
        $data = $request->all();
        if (!User::where('name', $data['name'])->where('locked', 1)->orwhere('reset_pwd',0)->count()) {
            return Response::error(200,'Locked OR Must Reset');
        }

        // 登录用户
        $login = OAuth::attempt(['name' => trim($data['name']), 'password' => $data['password']],$remember);
        if($login){
            $user_id =  auth()->user()->id;
            auth()->user()->update(['last_login_time'=>time()]);
            $this->initPrms($user_id);
            return $user = User::select('name','email','id','last_login_time')->find($user_id);
        }

        $ret = $this->auth->login($data);
        return Response::error(1010,'Login Failed,Please Try Again');
        event(new Mail($user));

    }

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

    public function destroy($id)
    {
        $ret = User::destroy(explode(',', $id));
        return response()->success([$ret]);
    }

    public function logout()
    {
        if(!auth()->user()->id){
            return response()->error(1723,'Already Logout');
        }
        OAuth::logout();
        if(OAuth::check()){
            return response()->error(1723,'Logout Failed');
        }
        return response()->success('success');
    }

    public function initPrms($id)
    {
        $role = auth()->user()->role->toArray();
        $prms = $this->arrayFilter(array_column($role,'prms'));
        $role_ids = $this->arrayFilter(array_column($role,'id'));
        $prms_info = array_column(Roles::getPrms($role_ids)->get()->toArray(),'prm');
        session(['prms_info'=>$this->arrayFilter($prms_info)]);
    }
}

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


class AuthController extends Controller
{
    use CommonTrait;

    /**
     * Display a listing of the resource.
     *
     * @param AuthInterface $auth
     * @param Request $request
     * @param RoleInterface $role
     */
//    public function __construct(AuthInterface $auth, Request $request, RoleInterface $role)
//    {
//        //this->middleware('auth.prms:all|user-operate');
////        $this->middleware('auth.prms:check|sss', ['except' => ['login', 'getLogin']]);
//    }

    public function __construt(AuthInterface $auth, Request $request, RoleInterface $role)
    {
        $this->middleware('auth.prms:all|user-manage', [
            'only' => ['create', 'update', 'destory']
        ]);
        $this->role = $role;
        $this->auth = $auth;
    }

    /**
     * 登录
     */
    public function login(Request $request)
    {
        $fill_able = [
            'name' => 'required|max:10|min:2',
            'password' => 'required|max:12|min:6',
        ];

        $message = [
            'name.required' => 'user_name can not empty',
            'password.required' => 'password can not empty'
        ];

        $remember = $request->has('remember') ? intval($request->has('remember')) : 0;
        $validator = Validator::make(Input::all(), $fill_able, $message);

        if ($validator->fails()) {
            return Response::error([], $validator->errors()->first());
        }

        $data = $request->all();
        if (!User::where('name', $data['name'])->count()) {
            return Response::error(200, 'Locked OR Must Reset');
        }

        // 登录用户
        $login = OAuth::attempt([
            'name' => trim($data['name']),
            'password' => $data['password']],
            $remember
        );

        if (!$login) {
            return Response::error(1010, 'Login Failed,Please Try Again');
        }

        $user_id = auth()->user()->id;
        auth()->user()->update(['last_login_time' => time()]);
        $this->initPrms($user_id);
        $user = User::select('name', 'email', 'id', 'last_login_time')->find($user_id);
        $user['auths'] = session('auth_infos');
        $user['navs'] = session('nav_infos');
        return Response::success($user);
//      event(new Mail($login));
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
        if (!auth()->user()->id) {
            return response()->error([], 'Already Logout');
        }
        OAuth::logout();
        session()->flush();

        if (OAuth::check()) {
            return response()->error([], 'Logout Failed');
        }

        return response()->success([], 'success');
    }

    public function initPrms()
    {
        $role = auth()->user()->role->toArray();
        $role_ids = $this->arrayFilter(array_column($role, 'id'));
        $auths = Roles::getPrms($role_ids)->get()->toArray();
        $nav_infos = Roles::getNavs($role_ids)->where('navs.enabled', 1)->get()->toArray();
        $nav_infos = $this->group_nav($nav_infos);
//        var_export($nav_infos);die;
        session([
            'auth_infos' => $this->arrayFilter($auths) ,
            'nav_infos' => array_values($nav_infos),
        ]);

        return true;
    }

    public function group_nav($nav_infos = [])
    {
        if (!$nav_infos) return [];
        $return_navs = [];
        foreach ($nav_infos as $nav) {
            if ($nav['nav_fid'] == 0) {
                $return_navs[$nav['id']] = $nav;
                continue;
            }
            $return_navs[$nav['nav_fid']]['childs'][] = $nav;
        }

        return $return_navs;
    }
}

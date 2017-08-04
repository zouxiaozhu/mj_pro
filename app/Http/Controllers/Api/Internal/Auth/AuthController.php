<?php

namespace App\Http\Controllers\Api\Internal\Auth;

use App\Repository\MjInterface\AuthInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(AuthInterface $auth, Request $request)
    {
//        $this->middleware('auth.prms:all|user-operate');
//        $this->auth    = $auth;
//        $this->request = $request;

    }

    function login()
    {

       $ret =  DB::table('users')->where('id','>',0)->first()->toArray();
        var_export($ret);die;





        $fill_able = [
            'name'     => 'required|max:10|min:2',
            'password' => 'required|max:12|min:6',

        ];
        $message   = [
            'name.required'     => 'User_Name Required',
            'password.required' => 'Password Required'
        ];
        $validator = Validator::make(Input::all(), $fill_able, $message);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }
        $data = $this->request->all();
        App::setlocale('zh_cn');
        $ret = $this->auth->login($data);
        return $ret;
        return view('Admin.Index.Index',compact('ret'));
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function logout()
    {
        $ret =  $this->auth->logout();
        return $ret;
    }
}

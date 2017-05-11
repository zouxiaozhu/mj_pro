<?php

namespace App\Http\Controllers\Api\Internal\Auth;

use App\Repository\MjInterface\AuthInterface;
use Illuminate\Http\Request;


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
    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
    }

    public function login()
    {
        $fill_able = [
            'name'     => 'required|max:10|min:2',
            'password' => 'required|max:12|min:6'
        ];
        $message   = [
            'name.required'     => 'User_Name Required',
            'password.required' => 'Password Required'
        ];
        $validator = Validator::make(Input::all(), $fill_able, $message);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        return $this->auth->login($fill_able);
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
}

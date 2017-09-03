<?php
use App\Models\Role_User;
use Illuminate\Database\Seeder;
use App\Models\Roles;
use App\Models\Auth;
use App\Models\Role_Auth;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAuths();
        $this->createRoles();
        $this->createAuthsRoles();
    }

    private function createRoles()
    {
        $role_user = [[
            'user_id' => 1,
            'role_id' => 1
        ],
            [
                'user_id' => 1,
                'role_id' => 2
            ]
        ];
        if (Role_User::count() == 0) {
            DB::table('user_role')->insert($role_user);
        }

        $role = [[
            'id'          => 1,
            'name'        => '超级管理员',
            'prms'        => '1',
            'super_admin' => 1,
            'description' => '我就是超级管理员,无所不能,攻无不克,战无不胜',
        ],
            [
                'id'          => 2,
                'name'        => '管理员',
                'prms'        => '1',
                'super_admin' => 1,
                'description' => '掌管着所有的权限分发',

            ]];

        if (Roles::count() == 0) {
            foreach ($role as $rol) {
                Roles::create($rol);
            }
        }
    }

    private function createAuths()

{
        $auth = [[
            'id'=>1,
            'prm'=>'all',
            'name'=>'所有权限'],
            [
             'id'=>2,
                'prm'=>'post',
                'name'=>'帖子'
        ]
        ];
        if(!Auth::count()){
            DB::table('auths')->truncate();
            DB::table('auths')->insert($auth);
        }
    }

    private function createAuthsRoles()
    {
        $role_auth = [
            [
            'id'=>1,
            'auth_id'=>'1',
            'auth_id'=>'1'],
            [
                'id'=>2,
                'auth_id'=>'2',
                'auth_id'=>'2'
            ]
        ];
        if(!Role_Auth::count()){
            DB::table('role_auth')->truncate();
            DB::table('role_auth')->insert($role_auth);
        }
    }

}

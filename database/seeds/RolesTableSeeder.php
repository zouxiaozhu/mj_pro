<?php
use App\Models\Role_User;
use Illuminate\Database\Seeder;
use App\Models\Roles;


class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
            'prms'        => 'all',
            'super_admin' => 1,
            'description' => '我就是超级管理员,无所不能,攻无不克,战无不胜',
        ],
            [
                'id'          => 2,
                'name'        => '管理员',
                'prms'        => 'all',
                'super_admin' => 1,
                'description' => '掌管着所有的权限分发',

            ]];

        if (Roles::count() == 0) {
           foreach ($role as $rol) {
                Roles::create($rol);
            }
        }
    }

}

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
        $this->createRoles();
        $this->createNavs();
        $this->createRoleNavs();
    }

    private function createRoles()
    {
        $role_user = [[
            'user_id' => 1,
            'role_id' => 1
        ], [
            'user_id' => 1,
            'role_id' => 2
        ]];

        if (Role_User::count() == 0) {
            DB::table('user_role')->insert($role_user);
        }

        $role = [[
            'id'          => 1,
            'name'        => '超级管理员',
            'super_admin' => 1,
            'description' => '我就是超级管理员,无所不能,攻无不克,战无不胜',
        ], [
            'id'          => 2,
            'name'        => '管理员',
            'super_admin' => 0,
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
        $auth = [
            [
             'id' => 1,
             'name' => '登录',
             'controller' => 'AuthController',
             'action' => 'getLogin'
            ]
        ];
        if(! Auth::count()) {
            DB::table('auths')->truncate();
            DB::table('auths')->insert($auth);
        }
    }

    private function createAuthsRoles()
    {
        $role_auth = [
            [
                'id' => 1,
                'role_id' => 1,
                'auth_id' => 1
            ], [
                'id' => 2,
                'role_id' => 2,
                'auth_id' => 2
            ]
        ];
        DB::table('role_auth')->truncate();
        DB::table('role_auth')->insert($role_auth);

    }

    private function createRoleNavs()
    {
        $role_nav = [
            [
                'role_id'=> 1,
                'nav_id'=> 1
            ], [
                'role_id'=> 1,
                'nav_id'=> 2
            ],[
                'role_id'=> 1,
                'nav_id'=> 3
            ],[
                'role_id'=> 1,
                'nav_id'=> 4
             ],[
                'role_id'=> 1,
                'nav_id'=> 5
            ],[
                'role_id'=> 1,
                'nav_id'=> 6
            ],[
                'role_id'=> 1,
                'nav_id'=> 7
            ],[
                'role_id'=> 1,
                'nav_id'=> 8
            ],[
                'role_id'=> 1,
                'nav_id'=> 9
            ],[
            'role_id'=> 1,
            'nav_id'=> 10
            ]
        ];

        DB::table('role_navs')->truncate();
        DB::table('role_navs')->insert($role_nav);

    }

    private function createNavs()
    {
        $navs = [
            [
                'id' => 1,
                'name' => '订单管理',
                'key' => '订单管理',
                'depth' => 1,
                'nav_fid' => 0,
                'url' => ''
            ], [
                'id' => 2,
                'name' => '充值订单',
                'key' => '新建订单',
                'depth' => 2,
                'nav_fid' => 1,
                'url' => '/api/service/add-order'
            ], [
                'id' => 3,
                'name' => '订单列表',
                'key' => '新建列表',
                'depth' => 2,
                'nav_fid' => 1,
                'url' => '/api/service/order-list'
            ],[
                'id' => 4,
                'name' => '会员管理',
                'key' => '会员管理',
                'depth' => 1,
                'nav_fid' => 0,
                'url' => ''
            ], [
                'id' => 5,
                'name' => '会员新增',
                'key' => '会员新增',
                'depth' => 2,
                'nav_fid' => 4,
                'url' => '/api/service/add-member'
            ],[
                'id' => 6,
                'name' => '会员列表',
                'key' => '会员列表',
                'depth' => 2,
                'nav_fid' => 4,
                'url' => '/api/service/member-list'
            ],[
                'id' => 7,
                'name' => '套餐管理',
                'key' => '套餐管理',
                'depth' => 1,
                'nav_fid' => 0,
                'url' => ''
            ], [
                'id' => 8,
                'name' => '套餐新增',
                'key' => '套餐新增',
                'depth' => 2,
                'nav_fid' => 7,
                    'url' => '/api/service/add-package'
            ],[
                'id' => 9,
                'name' => '套餐列表',
                'key' => '套餐列表',
                'depth' => 2,
                'nav_fid' => 7,
                'url' => '/api/service/package'
            ], [

                'id' => 10,
                'name' => '消费订单',
                'key' => '消费订单',
                'depth' => 2,
                'nav_fid' => 1,
                'url' => '/api/service/consume-order'
            ]

        ];
        DB::table('navs')->truncate();
        DB::table('navs')->insert($navs);
    }

    private function createPackages()
    {
        //('业务类型 1次数  2折扣');
        $package = [
            [
                'origin_price' => 80,
                'discount' => 8,
                'price' => (8/100)*80,
                'type' => 1,
                'business_type' => 2,
                'counts' => 0
            ],[
                'origin_price' => 60,
                'discount' => 8,
                'price' => (8/100)*60,
                'type' => 1,
                'business_type' => 2,
                'counts' => 0
            ],[
                'origin_price' => 0,
                'discount' => 0,
                'price' => 0,
                'type' => 1,
                'business_type' => 1,
                'counts' => 10
            ],[
                'origin_price' => 0,
                'discount' => 0,
                'price' => 0,
                'type' => 1,
                'business_type' => 1,
                'counts' => 20
            ]
        ];
        DB::table('member_packages')->truncate();
        DB::table('member_packages')->insert($package);
    }

    public function createMemberCards()
    {

    }

}

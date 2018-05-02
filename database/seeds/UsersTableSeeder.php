<?php

use Illuminate\Database\Seeder;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'id'             => 1,
                'name'           => 'zhanglong',
                'password'       => Hash::make(123456),// password_hash('123456', PASSWORD_BCRYPT),
                'create_user_id' => '0',
                'email'          => '1428804176@qq.com'
            ]
        ];
        if (User::count() == 0) {
            DB::table('users')->insert($user);
        }
    }
}

<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'id'    => 1,
            'name'           => 'zhanglong',
            'password'       => password_hash('123456', PASSWORD_BCRYPT),
            'create_user_id' => '0',
        ];

        
    }
}

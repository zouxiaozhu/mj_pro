<?php

use Illuminate\Database\Seeder;
use App\Models\Member\Member;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $member = [
            'name'=>'member',
            'password'=>\Illuminate\Support\Facades\Hash::make('123456'),
        ];

        if(Member::count() == 0){
            Member::create($member);
        }
    }
}

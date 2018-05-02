<?php

use Illuminate\Database\Seeder;
use MXU\Member\Models\MemberGroup;

class MemberGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->create_member_group_table_seeder();
    }
    
    public function create_member_group_table_seeder()
    {
        $member_group_insert = [
            [
                'id'         => 1,
                'order_id'   => 1,
                'group_name' => '一般会员',
                'is_system'  => 1,
                'type'       => 0,
                'exp_top'    => 0,
                'exp_down'   => 0,
                'star_num'   => 0,
                'status'     => 1,
                'site_id'    => 0,
            ],
            [
                'id'         => 2,
                'order_id'   => 2,
                'group_name' => '活跃会员',
                'is_system'  => 1,
                'type'       => 0,
                'exp_top'    => 0,
                'exp_down'   => 0,
                'star_num'   => 0,
                'status'     => 1,
                'site_id'    => 0,
            ],
            [
                'id'         => 3,
                'order_id'   => 3,
                'group_name' => '星标会员',
                'is_system'  => 1,
                'type'       => 0,
                'exp_top'    => 0,
                'exp_down'   => 0,
                'star_num'   => 0,
                'status'     => 1,
                'site_id'    => 0,
            ],
        ];
        
        if (!count(MemberGroup::all())) {
            MemberGroup::insert($member_group_insert);
        }
    }
}

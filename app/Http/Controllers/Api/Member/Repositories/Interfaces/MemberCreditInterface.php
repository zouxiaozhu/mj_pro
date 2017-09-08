<?php
namespace App\Http\Controllers\Api\Member\Repositories\Interfaces;
interface MemberCreditInterface
{
    public function getCreditRule($mark);

    public function getCreditRules();

    public function logCredit($data);

    public function getCreditTypes();

    public function addCredit($member_id, $operation);

    public function getLogCounts($member_id, $rule_id, $time = null);
}
<?php

namespace App\Http\Controllers\Api\Member\Event;

use App\Events\Event;
use App\Models\Member\Member as MemberModel;
use App\Http\Controllers\Api\Member\Repositories\Interfaces\MemberCreditInterface;

class CreditsEvent extends Event
{
    const TYPE_ACHIEVEMENT = 4;

    const TYPE_DAILY = 1;

    private $credit;

    public function __construct(MemberCreditInterface $credit)
    {
        log(111);
        $this->credit = $credit;
    }

    public function handle(array $payload)
    {
        $member_id = isset($payload['member_id']) ? $payload['member_id'] : '';
        $operation = isset($payload['type']) ? $payload['type'] : '';
        if (!$member_id || !$operation) {
            return false;
        }
        $types = $this->credit->getCreditTypes();
        if (empty($types)) {
            return false;
        }
        $rule = $this->credit->getCreditRule($operation);
        if (!$rule) {
            return false;
        }
        if (!$member = MemberModel::find($member_id)) {
            return false;
        }
        switch ($rule->rule_type) {
            case self::TYPE_ACHIEVEMENT:
                if ($this->credit->getLogCounts($member_id, $rule->id)) {
                    return false;
                }
                break;
            case self::TYPE_DAILY:
                if ($this->credit->getLogCounts($member_id, $rule->id, date('Ymd', TIMENOW)) >= $rule->rule_num) {
                    return false;
                }
                break;
        }
        $credits = [];
        foreach ($types as $type) {
            $credit                     = intval($rule->$type['db_field']);
            $credits[$type['db_field']] = $credit;
            $member->$type['db_field']  = $member->$type['db_field'] + $credit;
        }
        $log = [];
        if (!empty($credits)) {
            $member->save();
            $log = [
                'member_id'  => $member_id,
                'rule_id'    => $rule->id,
                'operation'  => $operation,
                'log_title'  => $rule->rule_name,
                'log_detail' => $rule->rule_detail,
                'log_time'   => date('Ymd', TIMENOW),
            ];
            $log = $this->credit->logCredit(array_merge($log, $credits));
        }

        if (!$log) {
            return false;
        }

        return $log;
    }
}
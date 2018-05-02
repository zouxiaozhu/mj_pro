<?php
namespace App\Http\Controllers\Api\Member\Repositories;

use MXUAPI\Members\Models\Member as MemberModel;
use MXUAPI\Members\Models\MemberCreditLog;
use MXUAPI\Members\Models\MemberCreditType;
use MXUAPI\Members\Repositories\Interfaces\MemberCreditInterface;
use MXUAPI\Members\Models\MemberCreditRule as Rule;

class MemberCredit implements MemberCreditInterface
{
    const TYPE_ACHIEVEMENT = 4;
    const TYPE_DAILY = 1;

    public function getCreditRule($operation)
    {
        $rule = Rule::inUse()->where('operation', $operation)->first();

        return $rule;
    }

    public function getCreditRules()
    {
        // TODO: Implement getCreditRules() method.
    }

    public function getCreditTypes()
    {
        $types = MemberCreditType::inUse()->get();

        return $types;
    }

    public function logCredit($data)
    {
        $log = MemberCreditLog::create($data);

        return $log;
    }

    public function addCredit($member_id, $operation)
    {
        $types = $this->getCreditTypes();
        if (empty($types)) {
            return false;
        }
        $rule = $this->getCreditRule($operation);
        if (!$rule) {
            return false;
        }
        $member = MemberModel::find($member_id);
        switch ($rule->rule_type) {
            case self::TYPE_ACHIEVEMENT:
                if ($this->getLogCounts($member_id, $rule->id)) {
                    return false;
                }
                break;
            case self::TYPE_DAILY:
                if ($this->getLogCounts($member_id, $rule->id, date('Ymd', TIMENOW)) >= $rule->rule_num) {
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
            $log = $this->logCredit(array_merge($log, $credits));
        }

        if (!$log) {
            return false;
        }

        return $log;
    }

    public function getLogCounts($member_id, $rule_id, $time = null)
    {
        $logs = MemberCreditLog::where(function ($query) use ($member_id, $rule_id, $time) {
            $query->where('member_id', $member_id);
            $query->where('rule_id', $rule_id);
            if ($time) {
                $query->where('log_time', $time);
            }
        })->get();

        $count = count($logs);

        return $count;
    }
}
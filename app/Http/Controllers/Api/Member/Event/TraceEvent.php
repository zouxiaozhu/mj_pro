<?php

namespace MXUAPI\Members\Events;

use MXUAPI\Events\Event;
use MXUAPI\Members\Models\MemberTrace;

class TraceEvent extends Event
{
    public function handle(array $payload)
    {
        if ($payload) {
            $trace = MemberTrace::create($payload);
        }

        return true;
    }
}
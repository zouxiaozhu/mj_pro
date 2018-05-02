<?php

namespace App\Repository\Middleware\MiddlewareInterface;

interface AuthPrmsInterface{
        public function verifyPrms($prms);
}

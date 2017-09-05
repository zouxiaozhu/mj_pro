<?php

namespace Zouxiaozhu\Media;

use Illuminate\Support\Facades\Facade;

class Media extends Facade {

    public static function getFacadeAccessor()
    {
        return 'media';
    }

}
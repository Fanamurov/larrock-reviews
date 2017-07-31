<?php

namespace Larrock\ComponentReviews\Facades;

use Illuminate\Support\Facades\Facade;

class LarrockReviews extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'larrockreviews';
    }

}
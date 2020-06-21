<?php

namespace Ajmariduena\LaravelPaymentez\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Ajmariduena\LaravelPaymentez\Skeleton\SkeletonClass
 */
class LaravelPaymentez extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-paymentez';
    }
}

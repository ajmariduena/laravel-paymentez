<?php

namespace Ajmariduena\LaravelPaymentez;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Ajmariduena\LaravelPaymentez\Skeleton\SkeletonClass
 */
class LaravelPaymentezFacade extends Facade
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

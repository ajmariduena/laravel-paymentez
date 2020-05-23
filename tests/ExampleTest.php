<?php

namespace Ajmariduena\LaravelPaymentez\Tests;

use Orchestra\Testbench\TestCase;
use Ajmariduena\LaravelPaymentez\LaravelPaymentezServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelPaymentezServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}

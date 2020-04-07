<?php

namespace Thepany\Template\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return ['Thepany\Template\TemplateServiceProvider'];
    }
}

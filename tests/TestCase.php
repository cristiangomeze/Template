<?php

namespace Cristiangomeze\Template\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return ['Cristiangomeze\Template\TemplateServiceProvider'];
    }
}

<?php

namespace PerfectOblivion\ActionServiceResponder\Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase as Orchestra;
use PerfectOblivion\ActionServiceResponder\ActionServiceResponderProvider;

class TestCase extends Orchestra
{
    /** @var array */
    protected $paths = [];

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->publishConfiguration();
        $this->setPackagePaths();
    }

    /**
     * Get the package service providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getPackageProviders($app): array
    {
        return [ActionServiceResponderProvider::class, TestServiceProvider::class];
    }

    /**
     * Set the configured package paths.
     */
    private function setPackagePaths(): void
    {
        $this->paths['action'] = Str::replaceFirst('\\', '/', Config::get('asr.action_namespace'));
        $this->paths['rule'] = Str::replaceFirst('\\', '/', Config::get('asr.custom_rule_namespace'));
        $this->paths['responder'] = Str::replaceFirst('\\', '/', Config::get('asr.responder_namespace'));
        $this->paths['service'] = Str::replaceFirst('\\', '/', Config::get('asr.service_namespace'));
    }

    /**
     * Publish the package configuration.
     */
    private function publishConfiguration(): void
    {
        Artisan::call('vendor:publish --provider="PerfectOblivion\ActionServiceResponder\ActionServiceResponderProvider"');
    }
}

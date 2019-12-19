<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use PerfectOblivion\ActionServiceResponder\Tests\TestCase;

class GenerateServiceTest extends TestCase
{
    /** @test */
    function the_service_command_creates_an_service()
    {
        $testStub = str_replace("\r\n", "\n", File::get(__DIR__.'/../stubs/service.stub'));

        $service = app_path($this->paths['service'].'/'.'Sample/SampleService.php');

        if (File::exists($service)) {
            unlink($service);
        }

        $this->assertFalse(File::exists($service));

        Artisan::call('asr:service Sample\\\SampleService');

        $this->assertTrue(File::exists($service));
        $this->assertEquals($testStub, str_replace("\r\n", "\n", File::get($service)));
    }
}

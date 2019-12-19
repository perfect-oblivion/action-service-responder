<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Validators;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use PerfectOblivion\ActionServiceResponder\Tests\TestCase;

class GenerateValidatorTest extends TestCase
{
    /** @test */
    function the_action_command_creates_an_action_from_stub()
    {
        $testStub = str_replace("\r\n", "\n", File::get(__DIR__.'/../stubs/validator.stub'));

        $validator = app_path($this->paths['service'].'/'.'Sample/SampleValidationService.php');

        if (File::exists($validator)) {
            unlink($validator);
        }

        $this->assertFalse(File::exists($validator));

        Artisan::call('asr:validation Sample\\\SampleValidationService');

        $this->assertTrue(File::exists($validator));
        $this->assertEquals($testStub, str_replace("\r\n", "\n", File::get($validator)));
    }
}

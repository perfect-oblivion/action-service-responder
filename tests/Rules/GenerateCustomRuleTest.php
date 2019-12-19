<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Rules;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use PerfectOblivion\ActionServiceResponder\Tests\TestCase;

class GenerateCustomRuleTest extends TestCase
{
    /** @test */
    function the_action_command_creates_an_action_from_stub()
    {
        $testStub = str_replace("\r\n", "\n", File::get(__DIR__.'/../stubs/rule.stub'));

        $rule = app_path($this->paths['rule'].'/'.'SampleRule.php');

        if (File::exists($rule)) {
            unlink($rule);
        }

        $this->assertFalse(File::exists($rule));

        Artisan::call('asr:rule SampleRule');

        $this->assertTrue(File::exists($rule));
        $this->assertEquals($testStub, str_replace("\r\n", "\n", File::get($rule)));
    }
}

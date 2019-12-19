<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Responders;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use PerfectOblivion\ActionServiceResponder\Tests\TestCase;

class GenerateResponderTest extends TestCase
{
    /** @test */
    function the_responder_command_creates_an_responder()
    {
        $testStub = str_replace("\r\n", "\n", File::get(__DIR__.'/../stubs/responder.stub'));

        $responder = app_path($this->paths['responder'].'/'.'Sample/SampleResponder.php');

        if (File::exists($responder)) {
            unlink($responder);
        }

        $this->assertFalse(File::exists($responder));

        Artisan::call('asr:responder Sample\\\SampleResponder');

        $this->assertTrue(File::exists($responder));
        $this->assertEquals($testStub, str_replace("\r\n", "\n", File::get($responder)));
    }
}

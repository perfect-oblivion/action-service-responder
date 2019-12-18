<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Responders;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use PerfectOblivion\ActionServiceResponder\Tests\TestCase;

class GenerateResponderTest extends TestCase
{
    /** @test */
    function the_responder_command_creates_an_responder()
    {
        $responder = app_path($this->paths['responder'].'/'.'User/StoreUserResponder.php');

        if (File::exists($responder)) {
            unlink($responder);
        }

        $this->assertFalse(File::exists($responder));

        Artisan::call('asr:responder User\\\StoreUserResponder');

        $this->assertTrue(File::exists($responder));
    }
}

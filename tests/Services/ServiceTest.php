<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Models\User;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Services\TestService;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Services\TestServiceWithValidation;
use PerfectOblivion\ActionServiceResponder\Tests\TestCase;
use PerfectOblivion\ActionServiceResponder\Services\ServiceCaller;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function calling_service_returns_the_result()
    {
        $expected = ['name' => 'Clayton Stone'];

        $this->assertEquals($expected, TestService::call($expected));
    }

    /** @test */
    public function calling_service_with_validation_validates_the_data()
    {
        $expected = ['name' => 'Clayton Stone', 'validated' => true];
        $caller = resolve(ServiceCaller::class);

        $this->assertEquals($expected, $caller->call(TestServiceWithValidation::class, ['name' => 'Clayton Stone']));
    }

    /** @test */
    public function calling_service_with_invalid_data_throws_an_exception()
    {
        $parameters = ['name' => ''];
        $caller = resolve(ServiceCaller::class);
        $this->expectException(ValidationException::class);

        $caller->call(TestServiceWithValidation::class, $parameters);
    }

    /** @test */
    public function route_parameters_are_available_on_services()
    {
        $user = factory(User::class)->create(['name' => 'Clayton Stone']);
        $response = $this->withExceptionHandling()
                        ->json('post', "/service-with-route-parameters/user/{$user->id}", ['name' => 'Clayton Stone']);

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Clayton Stone', 'user' => 'Clayton Stone']);
    }
}

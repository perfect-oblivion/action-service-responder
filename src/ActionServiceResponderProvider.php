<?php

namespace PerfectOblivion\ActionServiceResponder;

use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use PerfectOblivion\ActionServiceResponder\Actions\Commands\ActionMakeCommand;
use PerfectOblivion\ActionServiceResponder\Commands\AsrMakeCommand;
use PerfectOblivion\ActionServiceResponder\Responders\Commands\ResponderMakeCommand;
use PerfectOblivion\ActionServiceResponder\Services\AbstractServiceCaller;
use PerfectOblivion\ActionServiceResponder\Services\Commands\ServiceMakeCommand;
use PerfectOblivion\ActionServiceResponder\Services\Service;
use PerfectOblivion\ActionServiceResponder\Services\ServiceCaller;
use PerfectOblivion\ActionServiceResponder\Validation\Commands\CustomRuleMakeCommand;
use PerfectOblivion\ActionServiceResponder\Validation\Commands\FormRequestMakeCommand;
use PerfectOblivion\ActionServiceResponder\Validation\Commands\ValidationServiceMakeCommand;
use PerfectOblivion\ActionServiceResponder\Validation\ValidationService\ValidationService;

class ActionServiceResponderProvider extends BaseServiceProvider
{
    /**
     * Register application services.
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->setConfiguration();

        $this->setResolvingHooks();

        $this->registerCommands();

        $this->bootResponseMacros();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            ServiceCaller::class,
            AbstractServiceCaller::class,
        ];
    }

    private function registerBindings()
    {
        $this->app->singleton(ServiceCaller::class, function ($app) {
            return new ServiceCaller($app);
        });

        $this->app->alias(
            ServiceCaller::class,
            AbstractServiceCaller::class
        );
    }

    private function setConfiguration()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/asr.php' => config_path('asr.php'),
            ]);
        }

        $this->mergeConfigFrom(__DIR__.'/../config/asr.php', 'asr');
    }

    /**
     * Set the resolving hooks for package classes.
     */
    private function setResolvingHooks(): void
    {
        $this->resolvingValidatesWhenResolved();
        $this->resolvingValidationService();
        $this->afterResolvingService();
    }

    /**
     * Register the package commands.
     */
    private function registerCommands(): void
    {
        $this->commands([
            ActionMakeCommand::class,
            FormRequestMakeCommand::class,
            CustomRuleMakeCommand::class,
            ValidationServiceMakeCommand::class,
            ServiceMakeCommand::class,
            ResponderMakeCommand::class,
            AsrMakeCommand::class,
        ]);
    }

    /**
     * Boot the Response macros.
     */
    private function bootResponseMacros()
    {
        Response::mixin(new \PerfectOblivion\ActionServiceResponder\Payload\Macros\Response);
    }

    /**
     * Is the app running in the context of an Http request?
     */
    private function runningInHttpContext(): bool
    {
        return ! $this->app->runningInConsole();
    }

    /**
     * Are services configured to autorun?
     */
    private function shouldAutorunServices(): bool
    {
        return Config::get('asr.service_autorun');
    }

    /**
     * Set resolving hook for ValidatesWhenResolved.
     */
    private function resolvingValidatesWhenResolved(): void
    {
        $this->app->resolving(ValidatesWhenResolved::class, function ($resolved) {
            if (method_exists($resolved, 'prepareCustomRules')) {
                $resolved->prepareCustomRules();
            }
        });
    }

    /**
     * Set resolving hook for ValidationService.
     */
    private function resolvingValidationService(): void
    {
        $this->app->resolving(ValidationService::class, function ($resolved, $app) {
            if ($this->runningInHttpContext()) {
                $resolved->setData(resolve('request')->all());
            }
            $resolved->setContainer($app)->setRedirector($app->make(Redirector::class));
        });
    }

    /**
     * Set afterResolving hook for a Service.
     */
    private function afterResolvingService(): void
    {
        if (($this->runningInHttpContext() || $this->app->environment() === 'testing')) {
            $this->app->afterResolving(Service::class, function ($service) {
                if ($service->autorunIfEnabled && $this->shouldAutorunServices()) {
                    $service->autorun();
                }
            });
        }
    }
}

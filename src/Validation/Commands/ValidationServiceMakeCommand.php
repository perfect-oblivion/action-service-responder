<?php

namespace PerfectOblivion\ActionServiceResponder\Validation\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use PerfectOblivion\ActionServiceResponder\Validation\Exceptions\InvalidNamespaceException;

class ValidationServiceMakeCommand extends GeneratorCommand
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'asr:validation {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new validation service class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Validation Service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (false === parent::handle() && ! $this->option('force')) {
            return;
        }
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/validation-service.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $validationNamespace = Config::get('asr.validation_service_namespace', '');

        if (! $validationNamespace) {
            throw InvalidNamespaceException::missingValidationServiceNamespace();
        }

        return $rootNamespace.'\\'.$validationNamespace;
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        $input = Str::studly(trim($this->argument('name')));
        $validatorSuffix = Config::get('asr.validation_service_suffix');

        if (Config::get('asr.validation_service_override_duplicate_suffix')) {
            return Str::finish($input, $validatorSuffix);
        }

        return $input.$validatorSuffix;
    }
}

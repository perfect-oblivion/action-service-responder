<?php

namespace PerfectOblivion\ActionServiceResponder\Validation\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class FormRequestMakeCommand extends GeneratorCommand
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'asr:request {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Custom FormRequest';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Custom FormRequest';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/custom-request.stub';
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
        $namespace = Str::studly(trim(Config::get('asr.form_request_namespace')));

        return $namespace ? $rootNamespace.'\\'.$namespace : $rootNamespace;
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        $input = Str::studly(trim($this->argument('name')));
        $requestSuffix = Config::get('asr.form_request_suffix');

        if (Config::get('asr.form_request_override_duplicate_suffix')) {
            return Str::finish($input, $requestSuffix);
        }

        return $input.$requestSuffix;
    }
}

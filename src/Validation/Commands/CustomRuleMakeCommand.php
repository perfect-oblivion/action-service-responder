<?php

namespace PerfectOblivion\ActionServiceResponder\Validation\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class CustomRuleMakeCommand extends GeneratorCommand
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'asr:rule {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Custom Rule';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Custom Rule';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/custom-rule.stub';
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
        $namespace = Str::studly(trim(Config::get('asr.custom_rule_namespace')));

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
        $ruleSuffix = Config::get('asr.custom_rule_suffix');

        if (Config::get('asr.custom_rule_override_duplicate_suffix')) {
            return Str::finish($input, $ruleSuffix);
        }

        return $input.$ruleSuffix;
    }
}

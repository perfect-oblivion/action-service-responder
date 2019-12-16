<?php

namespace PerfectOblivion\ActionServiceResponder\Services\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use PerfectOblivion\ActionServiceResponder\Services\Exceptions\InvalidNamespaceException;

class ServiceMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asr:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new service definition and handler classes';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

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
        return __DIR__.'/stubs/service.stub';
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
        $serviceRootNamespace = Config::get('asr.service_namespace');

        if (! $serviceRootNamespace) {
            throw InvalidNamespaceException::missingServiceNamespace();
        }

        return $rootNamespace.'\\'.$serviceRootNamespace;
    }

    /**
     * Get the method name for the class.
     *
     * @param  string  $rootNamespace
     *
     * @return string
     */
    protected function getMethodName()
    {
        return Config::get('asr.service_method', 'run');
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        $input = $input = Str::studly(trim($this->argument('name')));
        $suffix = Config::get('asr.service_suffix');

        if (Config::get('asr.service_override_duplicate_suffix')) {
            return Str::finish($input, $suffix);
        }

        return $input.$suffix;
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     *
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceMethod($stub)->replaceClass($stub, $name);
    }

    /**
     * Replace the method name in the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     *
     * @return $this
     */
    protected function replaceMethod(&$stub)
    {
        $stub = str_replace(
            ['DummyMethod'],
            [$this->getMethodName()],
            $stub
        );

        return $this;
    }
}

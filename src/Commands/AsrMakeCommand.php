<?php

namespace PerfectOblivion\ActionServiceResponder\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AsrMakeCommand extends Command
{
    /** @var bool */
    protected $action = true;

    /** @var bool */
    protected $responder = true;

    /** @var bool */
    protected $service = true;

    /** @var bool */
    protected $validator = false;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'asr:make {name} {--no-action} {--no-service} {--no-responder}  {--valid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new set of ADR classes.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'ADR';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        $this->setOptions();

        $name = $this->argument('name');

        if ($this->action) {
            Artisan::call('asr:action', [
                'name' => $name,
                '--auto-service' => true,
            ]);
            $this->output->writeln('Action created successfully.');
        }

        if ($this->service) {
            Artisan::call('asr:service', [
                'name' => $name,
            ]);
            $this->output->writeln('Service created successfully.');
        }

        if ($this->responder) {
            Artisan::call('asr:responder', [
                'name' => $name.'Responder',
            ]);
            $this->output->writeln('Responder created successfully.');
        }

        if ($this->validator) {
            Artisan::call('asr:validation', [
                'name' => $name,
            ]);
            $this->output->writeln('Service validator created successfully.');
        }

        exit(0);
    }

    /**
     * Set the options for the command.
     *
     * @return void
     */
    protected function setOptions()
    {
        $this->action = ! $this->option('no-action');
        $this->responder = ! $this->option('no-responder');
        $this->service = ! $this->option('no-service');
        $this->validator = $this->option('valid');
    }
}

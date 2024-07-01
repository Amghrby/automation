<?php

namespace Amghrby\Automation\Console;

use Illuminate\Console\Command;

class InstallWorkflowsPackage extends Command
{
    protected $signature = 'workflows:install';
    protected $description = 'Install the Workflows package';

    public function handle()
    {
        $this->info('Installing Workflows package...');

        $this->call('vendor:publish', [
            '--provider' => "Amghrby\Workflows\WorkflowsServiceProvider",
            '--tag' => "migrations"
        ]);

        $this->call('vendor:publish', [
            '--provider' => "Amghrby\Workflows\WorkflowsServiceProvider",
            '--tag' => "config"
        ]);

        $this->call('migrate');

        $this->info('Workflows package installed successfully.');
    }
}
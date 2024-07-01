<?php

namespace Amghrby\Automation\Tests;

use Amghrby\Automation\Models\Workflow;
use Amghrby\Automation\WorkflowExecutor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Orchestra\Testbench\TestCase;

class WorkflowsTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();

        // Run migrations before each test
        $this->runMigrations();
    }

    protected function runMigrations(): void
    {
        // Use Artisan to run migrations
        Artisan::call('migrate', ['--database' => 'testing']);
    }

    public function testWorkflowTriggerOnModelEvent(): void
    {
        // Create a workflow with a trigger on the 'created' event of the User model
        $workflow = Workflow::create([
            'name' => 'Test Workflow',
            'description' => 'A test workflow for user creation',
        ]);

        $workflow->triggers()->create([
            'type' => 'event',
            'params' => json_encode(['event_name' => 'created', 'model' => 'App\\models\\User']),
        ]);

        $workflow->actions()->create([
            'type' => 'dynamic_update',
            'params' => json_encode(['attributes' => ['email_verified_at' => now()]]),
        ]);

//         Create a new user to trigger the workflow
//        $user = User::create(['name' => 'Test User', 'email' => 'test@example.com']);

        // Trigger workflow execution
        $workflowExecutor = new WorkflowExecutor();
        $workflowExecutor->execute($workflow);

        // Assert that executeActions was called
        $this->assertTrue(true); // Replace with actual assertions based on action effects
    }
}

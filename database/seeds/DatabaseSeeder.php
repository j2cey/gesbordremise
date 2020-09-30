<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(WorkflowActionTypeSeeder::class);
        $this->call(WorkflowStatusSeeder::class);
        $this->call(WorkflowObjectSeeder::class);
        $this->call(WorkflowObjectFieldSeeder::class);
        $this->call(WorkflowStepSeeder::class);
    }
}

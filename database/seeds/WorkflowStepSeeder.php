<?php

use App\WorkflowStep;
use Illuminate\Database\Seeder;

class WorkflowStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkflowStep::create([
            'titre' => "Traitement Terminé",
            'code' => "0",
            'description' => "Etape marquant la fin de tout Workflow",
            'posi' => 0,
        ]);
    }
}

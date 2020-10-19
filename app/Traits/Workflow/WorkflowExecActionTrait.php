<?php


namespace App\Traits\Workflow;


use App\WorkflowExec;
use App\WorkflowExecAction;

trait WorkflowExecActionTrait
{
    use ExecTrait;

    public function execaction() {
        // On créé une nouvelle exécution d action de Workflow (WorkflowExecAction)
        $model_type = $this->objectfield->object->model_type;
        $workflow_exec = WorkflowExec::where('workflow_id', $this->step->workflow_id)->orderBy('id', 'desc')->first();
        $new_exec = WorkflowExecAction::create([
            'workflow_action_id' => $this->id,
            'workflow_exec_id' => $workflow_exec->id,
            'model_id' => $this->getLastModelId($model_type),
            'report' => json_encode([]),
        ]);
    }
}

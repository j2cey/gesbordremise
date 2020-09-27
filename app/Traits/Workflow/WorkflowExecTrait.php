<?php


namespace App\Traits\Workflow;

use App\WorkflowExec;
use App\WorkflowExecAction;
use App\WorkflowStatus;

/**
 * Trait WorkflowExecTrait
 * Doit etre implementé par tout workflow
 *
 * @package App\Traits\Workflow
 */
trait WorkflowExecTrait
{
    public function exec() {
        // On créé une nouvelle exécution du Workflow (WorkflowExec)
        $new_exec = WorkflowExec::create([
            'workflow_id' => $this->id,
            'prev_step' => 0,
            'curr_step' => 1,
            'report' => json_encode([]),
        ]);

        // On parcoure les étapes (WorkflowStep) du workflow
        // pour créer des instance d'exécution d'action (WorkflowExecAction)
        $actions_count = 0;
        $prev_exec = new WorkflowExecAction();
        foreach ($this->steps as $step) {
            foreach ($step->actions as $action) {
                $new_action = WorkflowExecAction::create([
                    'workflow_exec_id' => $new_exec->id,
                    'workflow_action_id' => $action->id,
                    'workflow_status_id' => WorkflowStatus::coded("1")->first()->id,
                    'report' => json_encode([]),
                ]);
                if ($action->type->code === "1") {
                    // Action de type: Sur Workflow
                    $new_action->rawvalue = "";
                } else {
                    // Action de type: Sur Objet. On assigne
                    // le type de classe du model
                    $new_action->model_type = $action->objectfield->object->model_type;
                    // le champs qui sera modifié par l'acteur
                    $new_action->model_field = $action->objectfield->db_field_name;
                    // la dernière instance du modèle
                    $new_action->model_id = $this->getLastModelId($action->objectfield->object->model_type);
                    // le nom du champs (dans la base de données)
                    $new_action->model_field = $action->objectfield->db_field_name;
                    // TODO récupérer l'actuelle valeur du champs
                }
                if ($actions_count === 0) {
                    // la 1ere action
                    $new_action->current = 1;
                } else {
                    // la nème action
                    $prev_exec->next_exec_id = $new_action->id;
                    $new_action->prev_exec_id = $prev_exec->id;
                    // on enregistre le précédent
                    $prev_exec->save();
                }
                // on enregistre l'actuel
                $new_action->save();

                $prev_exec = $new_action;
                $actions_count += 1;
            }
        }
    }

    private function getLastModelId($model_type){
        return $model_type::orderBy('id', 'DESC')->first()->id;
    }
}

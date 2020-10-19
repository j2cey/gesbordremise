<?php

namespace App\Http\Controllers;

use App\Bordereauremise;
use App\WorkflowExecModelStep;
use App\WorkflowStep;
use Illuminate\Http\Request;

class WorkflowExecModelStepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WorkflowExecModelStep  $workflowexecmodelstep
     * @return \Illuminate\Http\Response
     */
    public function show(WorkflowExecModelStep $workflowexecmodelstep)
    {
        $workflowexecmodelsteps = WorkflowExecModelStep::where('id', $workflowexecmodelstep->id)
            ->first()
            ->load(['exec','step','actions', 'actions.type']);
        $actionvalues = [];
        if ($workflowexecmodelsteps->exec && $workflowexecmodelsteps->exec->currentstep) {
            foreach ($workflowexecmodelsteps->actions as $action) {
                if ($action->objectfield->valuetype_string) {
                    $actionvalues[$action->objectfield->db_field_name] = "";
                } elseif ($action->objectfield->valuetype_integer) {
                    $actionvalues[$action->objectfield->db_field_name] = "";
                } elseif ($action->objectfield->valuetype_boolean) {
                    $actionvalues[$action->objectfield->db_field_name] = "";
                } elseif ($action->objectfield->valuetype_datetime) {
                    $actionvalues[$action->objectfield->db_field_name] = "";
                } elseif ($action->objectfield->valuetype_image) {
                    $actionvalues[$action->objectfield->db_field_name] = "";
                } else {
                    $actionvalues[$action->objectfield->db_field_name] = "";
                }
            }
        }

        return ['data' => $workflowexecmodelsteps, 'actionvalues' => $actionvalues];
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WorkflowExecModelStep  $workflowexecmodelstep
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkflowExecModelStep $workflowexecmodelstep)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WorkflowExecModelStep  $workflowexecmodelstep
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkflowExecModelStep $workflowexecmodelstep)
    {
        $formInput = $request->all();

        //dd($formInput);

        // Validation
        $currmodelstep = WorkflowExecModelStep::with(['exec','exec.workflow','step','actions','actions.objectfield'])->where('id', $workflowexecmodelstep->id)->first();
        $validation_rules = [];
        $validation_messages = [];

        foreach ($currmodelstep->actions as $action) {
            $action->setValidationRules();
            $validation_rules = array_merge($validation_rules, $action->validation_rules);
            $validation_messages = array_merge($validation_messages, $action->validation_messages);
        }

        //request()->validate($validation_rules, $validation_messages);
        $request->validate($validation_rules, $validation_messages);
        //dd($request, $validation_rules,$validation_messages);

        //dd($validation_rules, $validation_messages,$formInput);

        // Parcourir et traiter les actions
        foreach ($currmodelstep->actions as $action) {
            // TODO: placer l'attribut image_dir dans la définition de la classe du model
            $action->Traiter($workflowexecmodelstep, $request, 'bordereauremises_scans');
        }

        // TODO: voir comment gérer dynamiquement le modèle traité (et son parent si besoin)
        if ($currmodelstep->model_type === "App\BordereauremiseFile") {
            $model_sub = $currmodelstep->model_type::where('id', $currmodelstep->model_id)->first();
            $model = Bordereauremise::where('id', $model_sub->bordereauremise_id)->first();
        } else {
            $model = $currmodelstep->model_type::where('id', $currmodelstep->model_id)->first();
        }
        $model->load(['type','localisation', 'modepaiement', 'lignes', 'lignes.currmodelstep','lignes.currmodelstep.step']);
        $model->load(['currmodelstep','currmodelstep.step','currmodelstep.actions']);

        return $model;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WorkflowExecModelStep  $workflowexecmodelstep
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkflowExecModelStep $workflowexecmodelstep)
    {
        //
    }
}

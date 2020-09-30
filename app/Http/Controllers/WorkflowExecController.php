<?php

namespace App\Http\Controllers;

use App\Workflow;
use App\WorkflowExec;
use App\WorkflowStatus;
use App\WorkflowStep;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class WorkflowExecController extends Controller
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
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param WorkflowExec $workflowexec
     * @return \Illuminate\Http\Response
     */
    public function show(WorkflowExec $workflowexec)
    {
        $workflowexec = WorkflowExec::where('id',$workflowexec->id)
            ->first()
            ->load(['workflow','currentstep','currentstep.actions','currentstep.actions.type','currentstep.actions.objectfield','workflowstatus']);
        $actionvalues = [];
        foreach ($workflowexec->currentstep->actions as $action) {
            $actionvalues[$action->objectfield->db_field_name] = null;
        }
        $actionvalues['setvalue'] = null;
        $actionvalues['motif_rejet'] = null;
        return view('workflowexecs.show', ['workflowexec' => $workflowexec, 'actionvalues' => json_encode($actionvalues)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param WorkflowExec $workflowexec
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkflowExec $workflowexec)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param WorkflowExec $workflowexec
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkflowExec $workflowexec)
    {
        $request->replace($request->all());
        $step_file = $request->file('step_files');

        $formInput = $request->all();
        $formInput['motif_rejet'] = ($formInput['motif_rejet'] === "null" ? null : $formInput['motif_rejet']);

        $currstep = WorkflowStep::with(['actions','actions.objectfield'])->where('id', $workflowexec->current_step_id)->first();
        $prevstep = WorkflowStep::where('workflow_id', $workflowexec->workflow_id)
            ->where('posi', $currstep->posi - 1)->first();
        $nextstep = WorkflowStep::where('workflow_id', $workflowexec->workflow_id)
            ->where('posi', $currstep->posi + 1)->first();

        $nextstep_id = WorkflowStep::coded("0")->first()->id;;
        $workflow_status_id = $workflowexec->workflow_status_id;

        if ( is_null($formInput['motif_rejet']) || $formInput['motif_rejet'] === "null" ) {
            //dd('motif_rejet null, Validation de l étape ',$formInput,is_null($formInput['motif_rejet']));
            // Validation de l'étape
            $model = $workflowexec->model_type::where('id', $workflowexec->model_id)->first();
            // On parcoure les actions pour assigner les valeurs
            foreach ($currstep->actions as $action) {
                if ($action->type->code === "2") {
                    // action sur objet
                    if ($action->objectfield->valuetype_datetime) {
                        // Type DateTime
                        $model->{$action->objectfield->db_field_name} = $formInput[$action->objectfield->db_field_name]; // Carbon::parse($formInput[$action->objectfield->db_field_name]);
                    } elseif ($action->objectfield->valuetype_image) {
                        $model->{$action->objectfield->db_field_name} = $this->verifyAndStoreImage($request, 'step_files', 'bordereauremises_scans');
                    } else {
                        $model->{$action->objectfield->db_field_name} = $formInput[$action->objectfield->db_field_name];
                    }
                } else {
                    // action sur workflow
                }
            }
            $model->save();
            if ($nextstep) {
                $nextstep_id = $nextstep->id;
            } else {
                // Statut Traitement Terminé
                $workflow_status_id = WorkflowStatus::coded("4")->first()->id;
            }
        } else {
            //dd('motif_rejet non null, Réjet de l étape ',$formInput,is_null($formInput['motif_rejet']));
            // Réjet de l'étape
            if ($prevstep) {
                $nextstep_id = $prevstep->id;
            } else {
                // Statut Rejété
                $workflow_status_id = WorkflowStatus::coded("5")->first()->id;
            }
        }
        $workflowexec->update([
            'current_step_id' => $nextstep_id,
            'workflow_status_id' => $workflow_status_id,
            'motif_rejet' => $formInput['motif_rejet'],
        ]);

        return json_encode($formInput);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WorkflowExec $workflowexec
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkflowExec $workflowexec)
    {
        //
    }

    public function verifyAndStoreImage( Request $request, $fieldname = 'image', $directory = 'unknown', $oldimage = ' ' ) {

        if( $request->hasFile( $fieldname ) ) {

            if (!$request->file($fieldname)->isValid()) {

                //flash('Invalid Image!')->error()->important();

                return null;//redirect()->back()->withInput();
            }

            $file_dir = config('app.' . $directory);// . '_filefolder');

            // Check if the old image exists inside folder
            if (file_exists( $file_dir . '/' . $oldimage)) {
                unlink($file_dir . '/' . $oldimage);
            }

            // Set image name
            $image = $request->file($fieldname);//$request->image;
            $image_name = md5($directory . '_' . time()) . '.' . $image->getClientOriginalExtension();

            // Move image to folder
            $image->move($file_dir, $image_name);

            return $image_name;
        }

        return null;

    }
}

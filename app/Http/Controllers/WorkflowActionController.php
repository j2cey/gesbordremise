<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkflowAction\CreateWorkflowActionRequest;
use App\Http\Requests\WorkflowAction\UpdateWorkflowActionRequest;
use App\WorkflowAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WorkflowActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return WorkflowAction[]|Collection
     */
    public function index()
    {
        $workflowactions = WorkflowAction::all();
        $workflowactions->load(['type','objectfield']);

        return $workflowactions;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateWorkflowActionRequest $request
     * @return Response
     */
    public function store(CreateWorkflowActionRequest $request)
    {
        $user = auth()->user();
        $formInput = $request->all();

        $new_workflowaction = WorkflowAction::create([
            'titre' => $formInput['titre'],
            'description' => $formInput['description'],
            'workflow_step_id' => $formInput['workflow_step_id'],
            'workflow_action_type_id' => $formInput['type']['id'],
            'workflow_object_field_id' => $formInput['objectfield']['id'],
        ]);

        return $new_workflowaction->load(['type','objectfield']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WorkflowAction  $workflowaction
     * @return Response
     */
    public function show(WorkflowAction $workflowaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WorkflowAction  $workflowaction
     * @return Response
     */
    public function edit(WorkflowAction $workflowaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateWorkflowActionRequest $request
     * @param \App\WorkflowAction $workflowaction
     * @return WorkflowAction
     */
    public function update(UpdateWorkflowActionRequest $request, WorkflowAction $workflowaction)
    {
        $user = auth()->user();
        $formInput = $request->all();

        $workflowaction->update([
            'titre' => $formInput['titre'],
            'description' => $formInput['description'],
            'workflow_step_id' => $formInput['workflow_step_id'],
            'workflow_action_type_id' => $formInput['type']['id'],
            'workflow_object_field_id' => $formInput['objectfield']['id'],
        ]);

        return $workflowaction->load(['type','objectfield']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WorkflowAction  $workflowaction
     * @return Response
     */
    public function destroy(WorkflowAction $workflowaction)
    {
        //
    }
}

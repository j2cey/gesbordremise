<?php

namespace App\Http\Controllers;

use App\Http\Requests\Workflow\CreateWorkflowRequest;
use App\Workflow;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class WorkflowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Workflow[]|Collection|Response
     */
    public function index()
    {
        $workflows = Workflow::all();
        $workflows->load(['steps','steps.profile','steps.actions','steps.actions.type','steps.actions.objectfield']);
        return $workflows;
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
     * @param CreateWorkflowRequest $request
     * @return Response
     */
    public function store(CreateWorkflowRequest $request)
    {
        $user = auth()->user();

        $formInput = $request->all();

        $new_workflow = Workflow::create([
            'titre' => $formInput['titre'],
            'description' => $formInput['description'],
            'user_id' => $user->id,
        ]);

        // Insert model_workflow
        DB::table('model_has_workflow')->insert([
            'workflow_id' => $new_workflow->id,
            'model_type' => $formInput['object']['model_type'],
        ]);

        return $new_workflow->load(['steps','steps.profile','steps.actions']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Workflow  $workflow
     * @return Response
     */
    public function show(Workflow $workflow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Workflow  $workflow
     * @return Response
     */
    public function edit(Workflow $workflow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Workflow  $workflow
     * @return Response
     */
    public function update(Request $request, Workflow $workflow)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Workflow  $workflow
     * @return Response
     */
    public function destroy(Workflow $workflow)
    {
        //
    }
}

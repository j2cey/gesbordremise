<?php

namespace App\Http\Controllers;

use App\WorkflowActionType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class WorkflowActionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return WorkflowActionType[]|Collection
     */
    public function index()
    {
        return WorkflowActionType::all();
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
     * @param  \App\WorkflowActionType  $workflowactiontype
     * @return \Illuminate\Http\Response
     */
    public function show(WorkflowActionType $workflowactiontype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WorkflowActionType  $workflowactiontype
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkflowActionType $workflowactiontype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WorkflowActionType  $workflowactiontype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkflowActionType $workflowactiontype)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WorkflowActionType  $workflowactiontype
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkflowActionType $workflowactiontype)
    {
        //
    }
}

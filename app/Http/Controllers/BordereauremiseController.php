<?php

namespace App\Http\Controllers;

use App\Bordereauremise;
use App\WorkflowExecAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BordereauremiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bordereauremises = Bordereauremise::all();
        $bordereauremises->load(['execaction','execaction.action','execaction.prevexec','execaction.nextexec']);

        //$bordereauremises->load(['steps','steps.profile','steps.actions','steps.actions.type','steps.actions.objectfield']);
        return $bordereauremises;
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
     * @param  \App\Bordereauremise  $bordereauremise
     * @return \Illuminate\Http\Response
     */
    public function show(Bordereauremise $bordereauremise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bordereauremise  $bordereauremise
     * @return \Illuminate\Http\Response
     */
    public function edit(Bordereauremise $bordereauremise)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bordereauremise  $bordereauremise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bordereauremise $bordereauremise)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bordereauremise  $bordereauremise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bordereauremise $bordereauremise)
    {
        //
    }
}

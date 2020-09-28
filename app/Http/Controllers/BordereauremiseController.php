<?php

namespace App\Http\Controllers;

use App\Bordereauremise;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BordereauremiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        return view('bordereauremises.index');
    }

    public function fetch() {
        $bordereauremises_all = Bordereauremise::all();
        $bordereauremises_all->load(['workflowexec','workflowexec.currentstep','workflowexec.currentstep.profile','workflowexec.workflowstatus']);

        $user = auth()->user();//User::where('id', Auth::user()->id())->first();

        //dd($user->hasRole(['Chef Agence','Admin']));

        $validation = [];

        $bordereauremises_arr = array();
        foreach ($bordereauremises_all as $bord) {

            if ($bord->workflowexec) {
                //$validation[] = [ "hasRole" . $bord->workflowexec->currentstep->profile->name => $user->hasRole([$bord->workflowexec->currentstep->profile->name, 'Admin']) ];
                if ($bord->workflowexec->currentstep) {
                    if ($user->hasRole([$bord->workflowexec->currentstep->profile->name, 'Admin'])) {
                        $bordereauremises_arr[] = $bord;
                    }
                }
            } else {
                $bordereauremises_arr[] = $bord;
            }
        }

        $bordereauremises = Collection::make($bordereauremises_arr);

        //dd("Validation: ", $validation, "Coll: ", $bordereauremises);
        return $bordereauremises_arr;
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
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bordereauremise  $bordereauremise
     * @return Response
     */
    public function show(Bordereauremise $bordereauremise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bordereauremise  $bordereauremise
     * @return Response
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
     * @return Response
     */
    public function update(Request $request, Bordereauremise $bordereauremise)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bordereauremise  $bordereauremise
     * @return Response
     */
    public function destroy(Bordereauremise $bordereauremise)
    {
        //
    }
}

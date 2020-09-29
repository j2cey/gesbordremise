<?php

namespace App\Http\Controllers;

use App\User;
use App\Bordereauremise;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Foundation\Application;

use Exception;
use Illuminate\Http\RedirectResponse;
use App\Http\Resources\SearchCollection;
use App\Http\Requests\Bordereauremise\FetchRequest;
use App\Http\Resources\Bordereauremise as BordereauremiseResource;
use App\Repositories\Contracts\IBordereauremiseRepositoryContract;

class BordereauremiseController extends Controller
{
    /**
     * @var IBordereauremiseRepositoryContract
     */
    private $repository;

    /**
     * BordereauremiseController constructor.
     *
     * @param IBordereauremiseRepositoryContract $repository [description]
     */
    public function __construct(IBordereauremiseRepositoryContract $repository) {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        return view('bordereauremises.index')
            ->with('perPage', new \Illuminate\Support\Collection(config('system.per_page')))
            ->with('defaultPerPage', config('system.default_per_page'));
    }

    /**
     * Fetch records.
     *
     * @param  FetchRequest     $request [description]
     * @return SearchCollection          [description]
     */
    public function fetch(FetchRequest $request): SearchCollection
    {
        return new SearchCollection(
            $this->repository->search($request), BordereauremiseResource::class
        );
    }

    public function fetch_old() {
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
        $bordereauremise = Bordereauremise::where('id',$bordereauremise->id)
            ->first()
            ->load(['workflowexec','workflowexec.currentstep','workflowexec.currentstep.actions','workflowexec.currentstep.actions.type','workflowexec.currentstep.actions.objectfield','workflowexec.currentstep.profile','workflowexec.workflowstatus']);

        $actionvalues = [];
        if ($bordereauremise->workflowexec && $bordereauremise->workflowexec->currentstep) {

            foreach ($bordereauremise->workflowexec->currentstep->actions as $action) {
                $actionvalues[$action->objectfield->db_field_name] = null;
            }
            $actionvalues['setvalue'] = null;
            $actionvalues['motif_rejet'] = null;
        }

        return view('bordereauremises.show', ['bordereauremise' => $bordereauremise, 'actionvalues' => json_encode($actionvalues)]);
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

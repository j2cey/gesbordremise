<?php

namespace App\Http\Controllers;

use App\BordereauremiseLoc;
use App\User;
use App\Bordereauremise;
use App\Workflow;
use App\WorkflowStep;
use Illuminate\Support\Facades\DB;
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
use Spatie\Permission\Models\Role;

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

    public function bordereauremisetest() {
        $user = auth()->user(); //$user = User::where(......, ........)->first(); // Without first() it's a query builder
        //$user = User::where('id', $user->id)->first();
        $userroles = Role::whereIn('id', DB::table('model_has_roles')->where('model_type','App\User')->where('model_id', $user->id)->select(['role_id'])
        )->get()->pluck('id')->toArray();
        $superroleIds = [1];
        //dd($userroles);
        $ids = [1,2,3];
        $cb = function ($query, $userroles)
        {
            $query->whereIn('role_id', $userroles);
        };
        $results = Bordereauremise::whereIn('id', $ids)->with(['workflowexec.currentstep' => $cb])->get();
        dd($results);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $localisations = BordereauremiseLoc::all();
        $bordereaux_wf = Workflow::where('model_type', 'App\Bordereauremise')->first();
        $statuts = $bordereaux_wf ? WorkflowStep::where('workflow_id', $bordereaux_wf->id)->orWhereNull('workflow_id')->get() : null;
        return view('bordereauremises.index')
            ->with('perPage', new \Illuminate\Support\Collection(config('system.per_page')))
            ->with('defaultPerPage', config('system.default_per_page'))
            ->with('localisations', $localisations)
            ->with('statuts', $statuts)
            ;
    }

    /**
     * Fetch records.
     *
     * @param  FetchRequest     $request [description]
     * @return SearchCollection          [description]
     */
    public function fetch(FetchRequest $request): SearchCollection
    {
        /*$request->replace([
            'search' => "32",
            'order_by' => "numero_transaction:asc"
        ]);*/
        //dd($request->all());
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
        $user = auth()->user();
        $exec_step_profile = $bordereauremise->workflowexec->currentstep->profile;
        $bordereauremise = Bordereauremise::where('id',$bordereauremise->id)
            ->first()
            ->load(['localisation','workflowexec','workflowexec.currentstep','workflowexec.currentstep.actions','workflowexec.currentstep.actions.type','workflowexec.currentstep.actions.objectfield','workflowexec.currentstep.profile','workflowexec.workflowstatus']);
        $hasexecrole = $user->hasRole([$exec_step_profile->name]) ? 1 : 0;
        //dd($hasexecrole);
        /*if ($user->hasRole([$exec_step_profile->name])) {
            $bordereauremise = Bordereauremise::where('id',$bordereauremise->id)
                ->first()
                ->load(['localisation','workflowexec','workflowexec.currentstep','workflowexec.currentstep.actions','workflowexec.currentstep.actions.type','workflowexec.currentstep.actions.objectfield','workflowexec.currentstep.profile','workflowexec.workflowstatus']);
        } else {
            $bordereauremise = Bordereauremise::where('id',$bordereauremise->id)
                ->without('workflowexec')->first();

            $bordereauremise->load(['localisation']);
        }*/
        $actionvalues = [];
        if ($bordereauremise->workflowexec && $bordereauremise->workflowexec->currentstep) {

            foreach ($bordereauremise->workflowexec->currentstep->actions as $action) {
                $actionvalues[$action->objectfield->db_field_name] = null;
            }
            $actionvalues['setvalue'] = null;
            $actionvalues['motif_rejet'] = null;
        }

        return view('bordereauremises.edit', ['bordereauremise' => $bordereauremise, 'actionvalues' => json_encode($actionvalues), 'hasexecrole' => $hasexecrole]);
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

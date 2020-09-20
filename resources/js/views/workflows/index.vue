<template>
    <div>

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Workflows</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Workflows</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="card card-default">
                    <div class="card-header">
                        <div class="form-inline float-left">
                            <span class="help-inline pr-1"> Liste des Workflows </span>
                            <button class="btn btn-xs btn-primary" @click="createNewWorkflow()">Nouveau</button>
                        </div>

                        <div class="card-tools">

                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="workflowlist">

                            <div class="card card-widget" v-for="(workflow, index) in workflows" v-if="workflows">
                                <div class="card-header">
                                    <div class="user-block">
                                        <span class="username text-primary">{{ workflow.titre }}</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-toggle="tooltip" @click="editWorkflow(workflow)">
                                            <i class="fa fa-pencil-alt"></i></button>
                                        <button type="button" class="btn btn-tool" data-toggle="collapse" data-parent="#workflowlist" :href="'#collapse-workflows-'+index"><i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" @click="deleteWorkflow(workflow.uuid, index)"><i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div :id="'collapse-workflows-'+index" class="panel-collapse collapse in">
                                    <div class="card-body" >

                                        <div class="row">
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <div class="info-box">

                                                    <div class="info-box-content">
                                                        <dt>Description</dt>
                                                        <dd>{{ workflow.description }}</dd>
                                                        <dt>Date Création</dt>
                                                        <dd>{{ workflow.create_at }}</dd>
                                                        <dd class="col-sm-8 offset-sm-4"></dd>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-md-6 col-sm-6 col-12">

                                                <div class="card card-default">
                                                    <div class="card-header">
                                                        <div class="form-inline float-left">
                                                            <span class="help-inline pr-1"> Etapes du Workflow </span>
                                                            <button class="btn btn-xs btn-primary" @click="createNewWorkflowStep(workflow.id)">Nouvelle</button>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <div class="card-body">
                                                        <div id="workflowStepslist">

                                                            <WorkflowSteps></WorkflowSteps>

                                                        </div>
                                                    </div>
                                                    <!-- /.card-body -->
                                                    <div class="card-footer">
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- /.col -->

                                        </div>

                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        .
                    </div>
                </div>
                <!-- /.card -->

                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        <AddUpdateWorflow></AddUpdateWorflow>
    </div>
</template>

<script>
    import AddUpdateWorflow from './addupdate'
    import AddUpdateStep from './steps/addupdate'
    import WorkflowSteps from './steps/steps'
    export default {
        name: "index",
        mounted() {
            this.$on('new_workflow_created', (workflow) => {
                window.noty({
                    message: 'Campagne créée avec succès',
                    type: 'success'
                })
                // insert la nouvelle workflow dans le tableau des workflows
                this.workflows.push(workflow)
            })

            this.$on('workflow_updated', (workflow) => {
                // on récupère l'index de la workflow modifiée
                let workflowIndex = this.workflows.findIndex(c => {
                    return workflow.id == c.id
                })

                this.workflows.splice(workflowIndex, 1, workflow)
                window.noty({
                    message: 'Campagne modifiée avec succès',
                    type: 'success'
                })

            })
        },
        components: {
            AddUpdateWorflow, AddUpdateStep, WorkflowSteps
        },
        data() {
            return {
                workflowtypes: [],
                workflows: []
            }
        },
        created() {
            /*axios.get('/smsworkflowtypes')
                .then(({data}) => this.workflowtypes = data);

            axios.get('/smsworkflows')
                .then(({data}) => this.workflows = data);*/
        },
        methods: {
            createNewWorkflow() {
                this.$emit('create_new_workflow')
            },
            createNewWorkflowStep() {
                this.$emit('create_new_workflowstep')
            },
            editWorkflow(workflow) {
                this.$emit('edit_workflow', { workflow })
            },
            deleteWorkflow(id, key) {
                if(confirm('Voulez-vous vraiment supprimer ?')) {
                    axios.delete(`/smsworkflows/${id}`)
                        .then(resp => {
                            this.workflows.splice(key, 1)
                            window.noty({
                                message: 'Campagne supprimée avec succès',
                                type: 'success'
                            })
                        }).catch(error => {
                        window.handleErrors(error)
                    })
                }
            }
        }
    }
</script>

<style scoped>

</style>

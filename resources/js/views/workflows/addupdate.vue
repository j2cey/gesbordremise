<template>
    <div class="modal fade" id="addUpdateWorkflow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" v-if="editing">Modifier Workflow</h5>
                    <h5 class="modal-title" id="exampleModalLabel" v-else>Créer Nouveau Workflow</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" @submit.prevent @keydown="workflowForm.errors.clear()">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="titre" class="col-sm-2 col-form-label">Titre</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="titre" name="titre" autocomplete="titre" autofocus placeholder="Titre" v-model="workflowForm.titre">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowForm.errors.has('titre')" v-text="workflowForm.errors.get('titre')"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="description" name="description" required autocomplete="description" autofocus placeholder="Description" v-model="workflowForm.description">
                                    <span class="invalid-feedback d-block" role="alert" v-if="workflowForm.errors.has('description')" v-text="workflowForm.errors.get('description')"></span>
                                </div>
                            </div>
                            <div class="form-group">
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" @click="updateWorkflow()" :disabled="!isValidCreateForm" v-if="editing">Enregistrer</button>
                    <button type="button" class="btn btn-primary" @click="createWorkflow()" :disabled="!isValidCreateForm" v-else>Créer Workflow</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>

    class Workflow {
        constructor(workflow) {
            this.titre = workflow.titre || ''
            this.description = workflow.description || ''
        }
    }
    export default {
        name: "addupdate",
        props: {

        },
        mounted() {
            this.$parent.$on('create_new_workflow', () => {

                this.editing = false
                this.workflow = new Workflow({})
                this.workflowForm = new Form(this.workflow)

                $('#addUpdateWorkflow').modal()
            })

            this.$parent.$on('edit_workflow', ({ workflow }) => {
                this.editing = true
                this.workflow = new Workflow(workflow)
                this.workflowForm = new Form(this.workflow)
                this.workflowId = workflow.uuid

                $('#addUpdateWorkflow').modal()
            })
        },
        created() {

        },
        data() {
            return {
                workflow: {},
                workflowForm: new Form(new Workflow({})),
                workflowId: null,
                editing: false,
                loading: false
            }
        },
        methods: {
            createWorkflow() {
                this.loading = true

                this.workflowForm
                    .post('/smsworkflows',"")
                    .then(newworkflow => {
                        this.loading = false
                        this.$parent.$emit('new_workflow_created', newworkflow)
                        $('#addUpdateWorkflow').modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            },
            updateWorkflow() {
                this.loading = true

                this.workflowForm
                    .put(`/smsworkflows/${this.workflowId}`,"")
                    .then(updworkflow => {
                        this.loading = false
                        this.$parent.$emit('workflow_updated', updworkflow)
                        $('#addUpdateWorkflow').modal('hide')
                    }).catch(error => {
                    this.loading = false
                });
            }
        },
        computed: {
            isValidCreateForm() {
                return this.workflowForm.titre && this.workflowForm.type && this.workflowForm.expediteur && !this.loading
            }
        }
    }
</script>

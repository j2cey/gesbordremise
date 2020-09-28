<template>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Project Detail</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Détails Bordereau</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Détails Bordereau</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                            <div class="row">
                                <div class="col-12 col-sm-12">

                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                Aris
                                            </h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <dl class="row">
                                                <dt class="col-sm-4">Date Remise</dt>
                                                <dd class="col-sm-8">{{ bordereauremise.date_remise }}</dd>
                                                <dt class="col-sm-4">Num. Transaction</dt>
                                                <dd class="col-sm-8">{{ bordereauremise.numero_transaction }}</dd>

                                                <dt class="col-sm-4">Localisation</dt>
                                                <dd class="col-sm-8">{{ bordereauremise.localisation }}</dd>
                                                <dt class="col-sm-4">Classe Paiement</dt>
                                                <dd class="col-sm-8">{{ bordereauremise.classe_paiement }}</dd>
                                            </dl>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-12">

                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                Agence
                                            </h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <dl class="row">
                                                <dt class="col-sm-4">Date Dépôt</dt>
                                                <dd class="col-sm-8">{{ bordereauremise.date_depot_agence }}</dd>
                                                <dt class="col-sm-4">Montant Déposé</dt>
                                                <dd class="col-sm-8">{{ bordereauremise.montant_depose_agence }}</dd>
                                                <dt class="col-sm-4">Scan</dt>
                                                <dd class="col-sm-8"></dd>
                                                <dt class="col-sm-4">Commentaire</dt>
                                                <dd class="col-sm-8">{{ bordereauremise.commentaire_agence }}</dd>
                                            </dl>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-12">

                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                Finances
                                            </h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <dl class="row">
                                                <dt class="col-sm-4">Date Valeur</dt>
                                                <dd class="col-sm-8">{{ bordereauremise.date_valeur }}</dd>
                                                <dt class="col-sm-4">Montant Déposé</dt>
                                                <dd class="col-sm-8">{{ bordereauremise.montant_depose_finance }}</dd>
                                                <dt class="col-sm-4">Commentaire</dt>
                                                <dd class="col-sm-8">{{ bordereauremise.commentaire_finance }}</dd>
                                            </dl>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>

                                </div>
                            </div>



                        </div>

                        <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                            <div class="row">
                                <h3 class="text-primary"><i class="fas fa-paint-brush"></i> Traitement</h3>
                                <form class="form-horizontal" @submit.prevent @keydown="workflowexecForm.errors.clear()">

                                    <div class="card-body">
                                        <div class="form-group row" v-for="(action, index) in bordereauremise.workflowexec.currentstep.actions" v-if="bordereauremise.workflowexec.currentstep">
                                            <div class="col-sm-10" v-if="action.type.code == 1">
                                                <input type="text" class="form-control" id="setvalue" name="setvalue" autocomplete="setvalue" placeholder="Titre" v-model="workflowexecForm.setvalue">
                                                <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has('setvalue')" v-text="workflowexecForm.errors.get('setvalue')"></span>
                                            </div>
                                            <div class="col-sm-10" v-else-if="action.objectfield.valuetype_string || action.objectfield.valuetype_integer">
                                                <input type="text" class="form-control" :id="action.objectfield.db_field_name" :name="action.objectfield.db_field_name" :placeholder="action.titre" v-model="workflowexecForm[action.objectfield.db_field_name]">
                                                <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.objectfield.db_field_name}`)" v-text="workflowexecForm.errors.get(`${action.objectfield.db_field_name}`)"></span>
                                            </div>
                                            <div class="col-sm-10" v-else-if="action.objectfield.valuetype_boolean">
                                                <input type="text" class="form-control" :id="action.objectfield.db_field_name" :name="action.objectfield.db_field_name" :placeholder="action.titre" v-model="workflowexecForm[action.objectfield.db_field_name]">
                                                <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.objectfield.db_field_name}`)" v-text="workflowexecForm.errors.get(`${action.objectfield.db_field_name}`)"></span>
                                            </div>
                                            <div class="col-sm-10" v-else-if="action.objectfield.valuetype_datetime">
                                                <VueCtkDateTimePicker v-model="workflowexecForm[action.objectfield.db_field_name]" :label="action.titre" format="YYYY-MM-DD hh:mm:ss" />
                                                <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.objectfield.db_field_name}`)" v-text="workflowexecForm.errors.get(`${action.objectfield.db_field_name}`)"></span>
                                            </div>
                                            <div class="col-sm-10" v-else-if="action.objectfield.valuetype_image">
                                                <input type="file" class="custom-file-input" :id="action.objectfield.db_field_name" :name="action.objectfield.db_field_name"  :ref="action.objectfield.db_field_name" @change="handleFileUpload">
                                                <label class="custom-file-label" :for="action.objectfield.db_field_name">{{ filename }}</label>
                                                <span class="invalid-feedback d-block" role="alert" v-if="workflowexecForm.errors.has(`${action.objectfield.db_field_name}`)" v-text="workflowexecForm.errors.get(`${action.objectfield.db_field_name}`)"></span>
                                            </div>
                                            <div class="col-sm-10" v-else>

                                            </div>
                                        </div>
                                    </div>

                                </form>

                                <div class="text-center mt-5 mb-3">
                                    <a href="#" class="btn btn-sm btn-primary" @click="validerEtape()">Valider</a>
                                </div>
                        </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>

</template>

<script>
    export default {
        name: "show",
        props: {
            bordereauremise_prop: {},
            actionvalues_prop: {}
        },
        data() {
            return {
                bordereauremise: this.bordereauremise_prop,
                actionvalues: this.actionvalues_prop,
                workflowexecForm: new Form(this.actionvalues_prop),
                filename: 'Télécharger un fichier',
                selectedFile : null,
            };
        },
        methods: {
            initActionvaluesArray() {
                let actionvalues = []
                for (var i = 0; i < this.exec_prop.currentstep.actions; i++) {

                }
            },
            handleFileUpload(event) {
                this.selectedFile = event.target.files[0];
                this.filename = (typeof this.selectedFile !== 'undefined') ? this.selectedFile.name : 'Télécharger un fichier';
            },
            validerEtape() {
                this.submitForm();
            },
            rejeterEtape() {
                this.$emit('validate_reject')
            },
            submitForm() {
                const fd = this.addFileToForm()

                console.log(this.workflowexecForm)

                //.post(`/workflowexecs`, fd)
                this.workflowexecForm
                    .put(`/workflowexecs/${this.execId}`, fd)
                    .then(data => {
                        window.location = "/bordereauremises";
                    }).catch(error => {
                    this.loading = false
                });
            },
            addFileToForm() {

                if (typeof this.selectedFile !== 'undefined') {
                    const fd = new FormData();
                    fd.append('step_files', this.selectedFile);
                    console.log("image added", fd);
                    return fd;
                } else {
                    const fd = undefined;
                    console.log("image not added", fd);
                    return fd;
                }
            },
        }
    }
</script>

<style scoped>

</style>

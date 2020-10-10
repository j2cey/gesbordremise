<template>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Détails Bordereau</h1>
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
                        <div class="col-12 col-md-12 col-lg-12 order-1 order-md-1">
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
                                            <div class="row">
                                                <div class="col-12 col-sm-6">
                                                    <dl class="row">
                                                        <dt class="col-sm-4">Date Remise</dt>
                                                        <dd class="col-sm-8">{{ bordereauremise.date_remise | formatDate }}</dd>
                                                        <dt class="col-sm-4">Num. Transaction</dt>
                                                        <dd class="col-sm-8">{{ bordereauremise.numero_transaction }}</dd>

                                                        <dt class="col-sm-4">Localisation</dt>
                                                        <dd class="col-sm-8">{{ bordereauremise.localisation.titre }}</dd>
                                                    </dl>
                                                </div>
                                                <div class="col-12 col-sm-6">
                                                    <dl class="row">
                                                        <dt class="col-sm-4">Classe Paiement</dt>
                                                        <dd class="col-sm-8">{{ bordereauremise.classe_paiement }}</dd>
                                                        <dt class="col-sm-4">Mode Paiement</dt>
                                                        <dd class="col-sm-8">{{ bordereauremise.mode_paiement }}</dd>
                                                        <dt class="col-sm-4">Montant Total</dt>
                                                        <dd class="col-sm-8">{{ bordereauremise.montant_total }}</dd>
                                                    </dl>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                    <div>
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-6 order-1 order-md-1">

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
                                            <dd class="col-sm-8">{{ bordereauremise.date_depot_agence | formatDate }}</dd>
                                            <dt class="col-sm-4">Montant Déposé</dt>
                                            <dd class="col-sm-8">{{ bordereauremise.montant_depose_agence }}</dd>
                                            <dt class="col-sm-4">Scan</dt>
                                            <dd class="col-sm-8"><a v-if="bordereauremise.scan_bordereau" href="#" @click.prevent="showImage" class="link-black text-sm"><i class="fas fa-link mr-1"></i> {{ bordereauremise.scan_bordereau }}</a></dd>
                                            <dt class="col-sm-4">Commentaire</dt>
                                            <dd class="col-sm-8">{{ bordereauremise.commentaire_agence }}</dd>
                                        </dl>
                                    </div>
                                    <!-- /.card-body -->
                                </div>

                            </div>

                            <div class="col-12 col-md-12 col-lg-6 order-2 order-md-1">

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
                                            <dd class="col-sm-8">{{ bordereauremise.date_valeur | formatDate }}</dd>
                                            <dt class="col-sm-4">Montant Validé</dt>
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
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card" v-if="canExec">
                <div class="card-header">
                    <h3 class="card-title">Traitement du Bordereau</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">

                            <h3 class="text-primary"><i class="fas fa-paint-brush"></i> {{ bordereauremise.workflowexec.currentstep.titre }}</h3>
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

                        </div>
                    </div>

                    <div class="row">
                        <div class="text-center mt-5 mb-3">
                            <a href="#" class="btn btn-sm btn-primary" @click="validerEtape(bordereauremise.workflowexec.uuid)">Valider</a>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
        <ImgShow></ImgShow>
    </div>

</template>

<script>
    import ImgShow from './img'
    export default {
        name: "show",
        props: {
            bordereauremise_prop: {},
            actionvalues_prop: {},
            hasexecrole_prop: 0
        },
        components: {
            ImgShow
        },
        data() {
            return {
                bordereauremise: this.bordereauremise_prop,
                actionvalues: this.actionvalues_prop,
                hasexecrole: this.hasexecrole_prop,
                workflowexecForm: new Form(this.actionvalues_prop),
                filename: 'Télécharger un fichier',
                filefieldname: null,
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
                this.filefieldname = event.target.name;
                this.filename = (typeof this.selectedFile !== 'undefined') ? this.selectedFile.name : 'Télécharger un fichier';
            },
            validerEtape(execId) {
                this.submitForm(execId);
            },
            rejeterEtape() {
                this.$emit('validate_reject')
            },
            submitForm(execId) {
                const fd = this.addFileToForm(this.filefieldname)

                //console.log(this.workflowexecForm)

                //.post(`/workflowexecs`, fd)
                this.workflowexecForm
                    .put(`/workflowexecs/${execId}`, fd)
                    .then(data => {
                        this.updateData(data);
                    }).catch(error => {
                    this.loading = false
                });
            },
            addFileToForm(fieldname) {

                if (typeof this.selectedFile !== 'undefined') {
                    const fd = new FormData();
                    fd.append(fieldname, this.selectedFile);
                    //console.log("image added", fd);
                    return fd;
                } else {
                    const fd = undefined;
                    //console.log("image not added", fd);
                    return fd;
                }
            },
            updateData(data) {
                //console.log(data);
                // MAJ du model
                this.bordereauremise = data;
                // MAJ de l'exec
                //this.bordereauremise = data.exec;
                // TODO: réévaluer le droit d'exécution du nouveau traitement
                this.hasexecrole = false;
                //console.log(this.bordereauremise, this.hasexecrole);
                window.noty({


                    message: 'Traitement effectué avec succès',
                    type: 'success'
                })
            },
            showImage() {
                this.$emit('show_image', this.bordereauremise.scan_bordereau)
            },
        },
        computed: {
            canExec() {
                return this.hasexecrole;
            }
        }
    }
</script>

<style scoped>

</style>

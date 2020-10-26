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
                                                        <dd class="col-sm-8">{{ bordereauremise.type.titre }}</dd>
                                                        <dt class="col-sm-4">Mode Paiement</dt>
                                                        <dd class="col-sm-8">{{ bordereauremise.modepaiement.titre }}</dd>
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
                                            <dd class="col-sm-8">
                                                <div class="attachment-block clearfix" v-if="bordereauremise.scan_bordereau">
                                                    <a v-if="bordereauremise.scan_bordereau" href="#" @click.prevent="showImage" class="link-black text-sm">
                                                        <img class="attachment-img" :src="scanUrl" alt="Attachment Image">
                                                    </a>
                                                    <!-- /.attachment-pushed -->
                                                </div>
                                            </dd>
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
                                        <div v-if="bordereauremise.type.code === 'BT_0'">
                                            <dl class="row">
                                                <dt class="col-sm-4">Date Valeur</dt>
                                                <dd class="col-sm-8">{{ bordereauremise.lignes[0].date_valeur_finance | formatDate }}</dd>
                                                <dt class="col-sm-4">Montant Validé</dt>
                                                <dd class="col-sm-8">{{ bordereauremise.lignes[0].montant_depose_finance }}</dd>
                                                <dt class="col-sm-4">Commentaire</dt>
                                                <dd class="col-sm-8">{{ bordereauremise.lignes[0].commentaire_finance }}</dd>
                                            </dl>
                                        </div>
                                        <div v-else>
                                            <div class="card-body table-responsive p-0" style="height: 200px;">
                                                <table class="table table-head-fixed text-nowrap">
                                                    <thead>
                                                    <tr>
                                                        <th>Réf. Chèque</th>
                                                        <th>Montant</th>
                                                        <th>Date Valeur</th>
                                                        <th>Montant Validé</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(ligne, index) in bordereauremise.lignes" v-if="bordereauremise.lignes">
                                                            <td>{{ ligne.reference }}</td>
                                                            <td>{{ ligne.montant }}</td>
                                                            <td>{{ ligne.date_valeur_finance | formatDate }}</td>
                                                            <td>{{ ligne.montant_depose_finance }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
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

            <div class="card" v-if="hasexecrole">
                <div class="card-header">
                    <h3 class="card-title">Traitement(s) à Effecuer:
                        <span v-if="actionsToExec < 3" class="badge badge-pill badge-success">{{ actionsToExec }}</span>
                        <span v-else-if="actionsToExec < 6" class="badge badge-pill badge-primary">{{ actionsToExec }}</span>
                        <span v-else-if="actionsToExec < 11" class="badge badge-pill badge-warning">{{ actionsToExec }}</span>
                        <span v-else class="badge badge-pill badge-danger">{{ actionsToExec }}</span>
                    </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">

                    <div class="card-body table-responsive p-0" style="height: 200px;">
                        <table class="table table-head-fixed table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>Statut</th>
                                <th>Date Dépot</th>
                                <th>Référence</th>
                                <th>Montant</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="bordereauremise.currmodelstep && bordereauremise.currmodelstep.workflow_step_id === bordereauremise.currmodelstep.exec.current_step_id">
                                <td>
                                    <span class="badge badge-pill badge-primary" v-if="bordereauremise.currmodelstep.step.posi == 0">{{ bordereauremise.currmodelstep.step.titre }}</span>
                                    <span class="badge badge-pill badge-info" v-else-if="bordereauremise.currmodelstep.step.posi == 1">{{ bordereauremise.currmodelstep.step.titre }}</span>
                                    <span class="badge badge-pill badge-success" v-else>{{ bordereauremise.currmodelstep.step.titre }}</span>
                                </td>
                                <td>{{ bordereauremise.date_depot_agence | formatDate }}</td>
                                <td></td>
                                <td>{{ bordereauremise.montant_total }}</td>
                                <td>
                                    <a href="#" @click.prevent="traiterEtape(bordereauremise.currmodelstep.uuid,bordereauremise.type.titre,bordereauremise.modepaiement.titre,bordereauremise.montant_total)">
                                        <i class="fa fa-pencil-square-o text-green" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr v-for="(ligne, index) in bordereauremise.lignes" v-if="ligne.currmodelstep && ligne.currmodelstep.workflow_step_id === ligne.currmodelstep.exec.current_step_id">
                                <td>
                                    <span class="badge badge-pill badge-primary" v-if="ligne.currmodelstep.step.posi == 0">{{ ligne.currmodelstep.step.titre }}</span>
                                    <span class="badge badge-pill badge-info" v-else-if="ligne.currmodelstep.step.posi == 1">{{ ligne.currmodelstep.step.titre }}</span>
                                    <span class="badge badge-pill badge-success" v-else>{{ ligne.currmodelstep.step.titre }}</span>
                                </td>
                                <td>{{ ligne.date_valeur | formatDate }}</td>
                                <td>{{ ligne.reference }}</td>
                                <td>{{ ligne.montant }}</td>
                                <td v-if="ligne.currmodelstep">
                                    <a href="#" @click.prevent="traiterEtape(ligne.currmodelstep.uuid,ligne.classe_paiement, ligne.reference, ligne.montant)">
                                        <i class="fa fa-pencil-square-o text-green" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
        <ImgShow></ImgShow>
        <StepTreatment></StepTreatment>
    </div>

</template>

<script>
    import ImgShow from './imgscan'
    import StepTreatment from '../workflowexecs/modelsteptreatment'
    export default {
        name: "show",
        props: {
            bordereauremise_prop: {},
            actionvalues_prop: {},
            hasexecrole_prop: 0
        },
        components: {
            ImgShow, StepTreatment
        },
        created() {
            console.log(this.bordereauremise_prop);
        },
        mounted() {
            this.$on('etape_traitee', (data) => {
                // Maj des données
                this.updateData(data)
            })
        },
        data() {
            return {
                bordereauremise: this.bordereauremise_prop,
                actionvalues: this.actionvalues_prop,
                hasexecrole: this.hasexecrole_prop,
                workflowexecForm: new Form({ 'actionvalues': this.actionvalues_prop }),
                filename: 'Télécharger un fichier',
                filefieldname: null,
                selectedFile : null
            };
        },
        methods: {
            updateData(data) {
                //console.log(data);
                // MAJ du model
                this.bordereauremise = data;
                // MAJ de l'exec
                //this.bordereauremise = data.exec;
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
            traiterEtape(id,classe_paiement,reference,montant) {

                let moredata = {
                    'Paiement': classe_paiement,
                    'Reference': reference,
                    'Montant': montant
                }

                axios.get(`/workflowexecmodelsteps/${id}`)
                    .then(({data}) => {
                        console.log('get workflowexecmodelsteps', data)
                        let actionvalues = data.actionvalues
                        let execmodelstep = data.data

                        this.$emit('traiter_etape', {execmodelstep, actionvalues, moredata})
                    });
            },
            async canExecStep(stepid) {

                axios.get(`/canexecstep/${stepid}`)

                    .then(resp => {
                        console.log('get canexecstep: ', resp.data)
                        if (resp) {
                            return resp.data.hasroles === 1;
                        } else {
                            return false;
                        }
                    })
                    .catch(err => {
                        console.log('get canexecstep error: ', err);
                        return false;
                    })

            }
        },
        computed: {
            actionsToExec() {
                let curr_step_actions_count = 0

                // post actionstoexec
                let actionstoexecForm = new Form(
                    { 'objects': [ this.bordereauremise, ...this.bordereauremise.lignes ]}
                )
                actionstoexecForm
                    .post('/actionstoexec')
                    .then(resp => {
                        curr_step_actions_count = resp.actionstoexec
                        console.log('post actionstoexec: ', curr_step_actions_count)
                        return curr_step_actions_count;
                    }).catch(error => {
                        console.log('post actionstoexec error: ', error);
                        return 0;
                });
            },
            actionsToExec_old() {
                let curr_step_actions_count = 0

                // post actionstoexec
                let actionstoexecForm = new Form(
                    { 'objects': [this.bordereauremise, ...this.bordereauremise.lignes ]}
                )
                actionstoexecForm
                    .post('/actionstoexec')
                    .then(data => {
                        console.log('post actionstoexec: ', data)
                    }).catch(error => {
                        console.log('post actionstoexec error: ', error)
                });

                // get canexecstep
                let newhasexecrole = true;

                if (this.hasexecrole) {
                    if (this.bordereauremise.currmodelstep) {
                        if (this.bordereauremise.currmodelstep.workflow_step_id === this.bordereauremise.currmodelstep.exec.current_step_id) {

                            axios.get(`/canexecstep/${this.bordereauremise.currmodelstep.exec.current_step_id}`)

                                .then(resp => {
                                    if (resp) {
                                        newhasexecrole = newhasexecrole && (resp.data.hasroles === 1)
                                        if (newhasexecrole) {
                                            curr_step_actions_count = 1;
                                        }
                                        console.log('canexecthisstep (bordereauremise): ', newhasexecrole, curr_step_actions_count )
                                    } else {
                                        newhasexecrole = false;
                                    }
                                })
                                .catch(err => {
                                    console.log('get canexecstep error: ', err);
                                    newhasexecrole = false;
                                })
                        }
                    }
                    if (this.bordereauremise.lignes) {
                        for (let i in this.bordereauremise.lignes) {
                            let ligne = this.bordereauremise.lignes[i]
                            if (ligne.currmodelstep && ligne.currmodelstep.workflow_step_id === ligne.currmodelstep.exec.current_step_id) {

                                axios.get(`/canexecstep/${ligne.currmodelstep.exec.current_step_id}`)

                                    .then(resp => {
                                        console.log('get canexecstep: ', resp.data)
                                        if (resp) {
                                            console.log('canexecthisstep (ligne ' + i + '): ', resp.data.hasroles)
                                            newhasexecrole = newhasexecrole && (resp.data.hasroles === 1)
                                            if (newhasexecrole) {
                                                curr_step_actions_count = curr_step_actions_count + 1;
                                            }
                                        } else {
                                            newhasexecrole = false;
                                        }
                                    })
                                    .catch(err => {
                                        console.log('get canexecstep error: ', err);
                                        newhasexecrole = false;
                                    })
                            }
                        }
                    }
                } else {
                    newhasexecrole = false;
                }
                this.hasexecrole = newhasexecrole;
                console.log('actionsToExec: ', this.hasexecrole, curr_step_actions_count);
                return curr_step_actions_count;
            },
            scanUrl() {
                if (this.bordereauremise.scan_bordereau) {
                    return '/uploads/bordereauremises/scans/' + this.bordereauremise.scan_bordereau
                } else {
                    return ""
                }
            }
        }
    }
</script>

<style scoped>

</style>

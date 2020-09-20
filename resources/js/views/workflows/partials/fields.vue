<template>
    <div>
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
</template>

<script>
    class Workflow {
        constructor(workflow) {
            this.titre = workflow.titre || ''
            this.description = workflow.description || ''
        }
    }
    export default {
        name: "fields",
        props: {
            workflow: {}
        },
        data() {
            return {
                campaign: {},
                campaignForm: new Form(new Campaign({})),
                campaignId: null,
                filename: 'Télécharger un fichier',
                editing: false,
                loading: false
            }
        },
    }
</script>

<style scoped>

</style>

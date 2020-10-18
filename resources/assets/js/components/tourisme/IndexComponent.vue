<template>
    <b-card>
        <b-card-title>
            <div class="row">
                <div class="col-6">
                    <h4> {{titre}}</h4>
                </div>
                <div class="col-6" style="text-align: right;">
                    <div v-if="list">
                        <b-button variant="outline-success" v-on:click="onCreate()" size="sm">+ Site</b-button>
                    </div>

                    <div v-if="!list">
                        <b-button variant="outline-success" v-on:click="onList()" size="sm"> << Liste</b-button>
                    </div>
                </div>
            </div>
            <hr class="colorgraph"><br>
        </b-card-title>
        <b-card-text>
            <template v-if="list">
                <list-tourisme></list-tourisme>
            </template>

            <template v-if="detail">
                <detail-tourisme :tourisme=tourisme_detail></detail-tourisme>
            </template>

            <template v-if="create">
                <create-tourisme></create-tourisme>
            </template>

            <template v-if="update">
                <update-tourisme :tourisme=tourisme_update></update-tourisme>
            </template>

        </b-card-text>
    </b-card>
</template>

<script>
    export default {
        data() {
            return {
                list: true,
                create: false,
                detail: false,
                update: false,
                tourisme_detail:null,
                tourisme_update: null ,
                titre: "Liste des Sites",
            }
        },
        mounted() {

            /*
             *  On écoute les événements pour les modifications et le détail venant
             *  du component listPartenaire
             */
            this.$root.$on('detail-tourisme', (tourisme) => {
                this.onDetail(tourisme);
            });

            this.$root.$on('update-tourisme' , (tourisme) => {
                this.onUpdate(tourisme);
            });
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.update = false;
                this.titre = "Création d'un site touristique";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des sites";
            },

            onUpdate(tourisme) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du site : " + " " + tourisme.nom;
                this.tourisme_update = tourisme;
            },

            onDetail(tourisme) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du site : "+" " +tourisme.nom;
                this.tourisme_detail= tourisme;
            }
        }
    }
</script>

<style scoped>

</style>
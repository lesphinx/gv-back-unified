<template>
    <b-card>
        <b-card-title>
            <div class="row">
                <div class="col-6">
                    <h4> {{titre}}</h4>
                </div>
                <div class="col-6" style="text-align: right;">
                    <div v-if="list">
                        <b-button variant="outline-success" v-on:click="onCreate()" size="sm">+ province</b-button>
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
                <list-province></list-province>
            </template>

            <template v-if="detail">
                <detail-province :province=province_detail></detail-province>
            </template>

            <template v-if="create">
                <create-province></create-province>
            </template>

            <template v-if="update">
                <update-province :province=province_update></update-province>
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
                province_detail:null,
                province_update: null ,
                titre: "Liste des province",
            }
        },
        mounted() {

            /*
             *  On écoute les événements pour les modifications et le détail venant
             *  du component listPartenaire
             */
            this.$root.$on('detail-province', (province) => {
                this.onDetail(province);
            });

            this.$root.$on('update-province' , (province) => {
                this.onUpdate(province);
            });
        },
        methods: {
            onCreate() {
                this.create = true;
                this.list =false;
                this.detail = false;
                this.update = false;
                this.titre = "Création d'une province";
            },
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des provinces";
            },

            onUpdate(province) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du province : " + " " + province.nom;
                this.province_update = province;
            },

            onDetail(province) {
                this.create = false;
                this.list =false;
                this.detail = true;
                this.update = false;
                this.titre=" Détail du province : "+" " +province.nom;
                this.province_detail= province;
            }
        }
    }
</script>

<style scoped>

</style>
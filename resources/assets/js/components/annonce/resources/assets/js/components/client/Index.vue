<template>
    <div class="card">
        <div>
            <div class="card-title">
                <div class="row">
                    <div class="col-6">
                        <h4> {{titre}}</h4>
                    </div>
                </div>
                <hr class="colorgraph"><br>
            </div>
            <div class="card-text">

                <div v-if="list">
                    <client></client>
                </div>

                <div  v-if="update">
                    <client-update></client-update>
                </div>


            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                list: true,
                create: false,
                detail: false,
                update: false,
                client_detail:null,
                client_update: null ,
                titre: "Liste des client",
            }
        },
        mounted() {
            this.$root.$on('client-update' , (client) => {
                this.onUpdate(client);
            });
        },
        methods: {
            onList() {
                this.create = false;
                this.list =true;
                this.detail = false;
                this.update = false;
                this.titre = "Liste des client ";
            },

            onUpdate(client) {
                this.create = false;
                this.list =false;
                this.update =true;
                this.detail = false;
                this.titre = "Modification du client : ";
                this.client_update = client;
            }
        }
    }
</script>

<style scoped>

</style>
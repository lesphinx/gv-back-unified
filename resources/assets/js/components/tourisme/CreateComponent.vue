<template>

    <div>
        <b-form @submit.prevent="onSubmit" @reset="onRestForm">
            <b-row>
                <div class="col-12">
                    <b-row>
                       
                        <div class="form-group col-12">
                            <label for="nom" class="form-control-label obligatoire"> Titre </label>
                            <input type="text"  v-model="form_site.nom" class="form-control" id="nom" required>
                            <p v-if="errors.title" style="color: red">
                                {{errors.title[0]}}
                            </p>
                        </div>
                    </b-row>
                    <b-row>
                        <b-form-group class="col-6">
                            <label>Pays</label>
                            <b-form-select v-model="form_site.pays_site" :options="pays" v-on:input="charger_province(form_site.pays_site)">
                                <template slot="first">
                                    <option :value="null" disabled> -- Selectionnez un pays --</option>
                                </template>
                            </b-form-select>
                        </b-form-group>
                        <b-form-group class="col-6">
                            <label class="obligatoire">province</label>
                            <b-form-select v-model="form_site.province" :options="provinces">
                                <template slot="first">
                                    <option :value="null" disabled> -- Selectionnez une province --</option>
                                </template>
                            </b-form-select>
                            <p v-if="errors.province" style="color: red">
                                {{errors.province[0]}}
                            </p>
                        </b-form-group>
                    </b-row>
        
                </div>
                <div class="col-12">
                    <div class="form-group col-12">
                    <label for="description">Description de la site</label>
                    <textarea class="form-control" rows="5"
                              style="height: 85%; max-height: 100%;"
                              v-model="form_site.description" id="description"
                              placeholder="Saisissez la description de votre object en site"
                    ></textarea>
                    <p v-if="errors.description" style="color: red">
                        {{errors.description[0]}}
                    </p>
                </div>
                </div>
            </b-row>

            <b-row class="col-12">
                <multiple-image :old_images=old_images></multiple-image>
            </b-row>
            <div class="row">
                <div class="col-6">
                    <b-button type="reset" block variant="danger">Annuler</b-button>
                </div>
                <div class="col-6">
                    <b-button type="submit" block variant="success">Enregistrer </b-button>
                </div>
            </div>
        </b-form>
    </div>
</template>


<script>
    import axios from 'axios';
    import DatePicker from 'vue2-datepicker';

    export default {
        props: ['site'],
        components: { DatePicker},
        data() {
            return {
                form_site: {
                    'nom': '',
                    'description': '',
                    'province': '',
                    'photos': [],
                    'image_to_remove': null,
                },
                errors: [],

                update: false,
                pays: [] ,
                province: [],
               // old_images: this.site === null ? null: this.site.images
            }
        },
        computed: {
        },
        mounted() {

            this.init_form();

             this.load_countries();
            this.load_province();
            // On écoute le composant image
            this.$root.$on('images' , (images_loaded) => {
                this.put_image(images_loaded);
            });

            this.$root.$on('images_to_remove', (tab_id) => {
               this.form_site.image_to_remove = tab_id;
            });

        },
        methods: {

            init_form() {
               if ( this.site == null) {
                   this.update = false;
               } else {
                   this.update = true;
                   this.form_site.description = this.site.description;
                   this.form_site.nom = this.site.nom;
                   this.form_site.province = this.site.province;
               }

            },

            put_image(images) {
                this.form_site.photos = images;
            },

            is_updated(){
                return !(
                    this.form_site.nom === this.site.nom &&
                    this.form_site.description === this.site.description &&
                    this.form_site.photos === [] &&
                    this.form_site.image_to_remove === null
                ) ;
            },

            onSubmit() {

                if(this.update) {
                    // Nous sommes dans un de modification de site
                    if (!this.is_updated()) {
                        swal.fire({
                            title: 'Pas de modification!',
                            type: 'error',
                            text: 'Vous n\'avez rien modifié!!!',
                        });
                    } else {
                        axios.put('site/'+this.site.slug, this.form_site)
                            .then((response) => {
                                swal.fire({
                                    title: 'Modification!',
                                    type: 'success',
                                    text: 'site modifiée avec succès!!!',
                                });
                            })
                    }
                } else {
                    axios.post('/site', this.form_site)
                        .then((response) => {
                            if (response.data.status === 0 ) {
                                this.errors = response.data.errors;
                                toast.fire({
                                    type: 'error',
                                    title: 'Erreur !',
                                    html: response.data.message
                                });
                            } else {
                                swal.fire({
                                    title: 'Création!',
                                    type: 'success',
                                    text: 'site planifié !!!',
                                });
                                this.onRestForm();
                            }
                        }).catch(error => console.log(error));
                }

            },

            onRestForm() {
                this.form_site.nom = '';
                this.form_site.description = '';
                this.form_site.photos = [];
                this.form_site.image_to_remove = null;
                this.form_site.pays_site = null;
                this.form_site.province = province;
            },

            

            load_countries() {
                axios.get('/pays')
                    .then((response) =>{
                        response.data.content.pays.data.forEach( (country) => {
                            this.pays.push({
                                value: country.id,
                                text: country.nom,
                            });
                        });

                    }).catch((response) => {
                        console.log(response);
                    }
                );
            },

            // Charger les provinces
            load_province() {
                this.province = [];
                let cities = [];
                this.axios.get('/province')
                    .then((response) => {
                        cities = response.data.content;
                        cities.forEach((province) => {
                            this.province.push({
                                id: province.id,
                                nom: province.nom,
                                pays_id: province.pays.id
                            })
                        })
                    }).catch(err => console.log(err));
            },


            // En fonction du pays de depart
            charger_province($id_pays) {
                this.provinces = [];
                this.province.forEach( (city) => {
                    if (city.pays_id === $id_pays) {
                        this.provinces.push({
                            value: city.id,
                            text: city.nom,
                        });
                    }
                });
            },
        }
    }
</script>

<style scoped>
    label.obligatoire:after {
        content: " *";
        color: red;
        font-size: 15px;
    }
    label {
        color: #002752;
        display: block;
        font-size: 15px;
    }
    select, input, textarea{
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        border: 1px solid #C2C2C2;
        box-shadow: 1px 1px 4px #EBEBEB;
        -moz-box-shadow: 1px 1px 4px #EBEBEB;
        -webkit-box-shadow: 1px 1px 4px #EBEBEB;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        padding: 7px;
        outline: none;
    }
</style>

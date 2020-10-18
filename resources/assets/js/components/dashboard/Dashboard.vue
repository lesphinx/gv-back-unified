<template>

    <div>
        
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-check-2 text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">R&eacute;servations confirm&eacute;es</p>
                                <p class="card-title text-success">{{ reservationsConfirmes }}</p><p>
                            </p></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>

                    <div class="stats">
                        <i class="text-success">Nombre total des réservations confirmées cette année</i> 
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-simple-remove text-danger"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">R&eacute;servations annul&eacute;es</p>
                                <p class="card-title text-danger"> {{ reservationsAnnules }}
                                </p><p>
                            </p></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="text-danger">Nombre total des réservations annulées cette année</i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-send text-info"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Voyages enregistr&eacute;es</p>
                                <p class="card-title text-info">{{  voyages }}
                                </p><p>
                            </p></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                       <i class="text-info">Nombre total des voyages enrégistrés</i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-single-02 text-primary"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Nombre total des clients</p>
                                <p class="card-title text-primary">{{  clients }}
                                </p><p>
                            </p></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="text-primary">Nombre total des clients</i>
                    </div>
                </div>
            </div>
        </div>    
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-money-coins text-warning"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category"> Total Recettes voyages</p>
                                <p class="card-title text-warning">{{ recettes }} {{ ' XAF' }}
                                </p><p>
                            </p></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                        <i class="text-warning"> Total des recettes decette année</i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-pin-3 text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Locations enrégistrées</p>
                                <p class="card-title text-success"> {{ locations }}
                                </p><p>
                            </p></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <hr>
                    <div class="stats">
                         <i class="text-success"> Nombre total des locations enrégistrés</i>
                    </div>
                </div>
            </div>
        </div>
      
     
        
    </div>

    <div class="row">
            
        <div class="col-md-4 col-sm-4 small">                
            <line-chart :chart-data="datacollection4"></line-chart>
        </div>   

        <div class="col-md-4 col-sm-4 small"> 
            <line-chart :chart-data="datacollection6"></line-chart>
        </div>   
    
        <div class="col-md-4 col-sm-4 small"> 
            <line-chart :chart-data="datacollection1"></line-chart>
        </div>          
               
    </div>

<!--
<div class="row">

<div class="col-md-6">

    <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Nom client</th>
      <th scope="col">Prénom client</th>
      <th scope="col">Sexe</th>
      <th scope="col">Date de voyage</th>
      <th scope="col">De</th>
      <th scope="col">A</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td>@mdo</td>
      <td>@mdo</td>
      <td>@mdo</td>
    </tr>
    <tr>
     <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td>@mdo</td>
      <td>@mdo</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td>@mdo</td>
      <td>@mdo</td>
      <td>@mdo</td>
    </tr>
  </tbody>
</table>

</div>


<div class="col-md-6">

    <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Larry</td>
      <td>the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table>

</div>

</div-->
    </div>
    
      
</template>

<script>

  import LineChart from './chart.js'
  import LineChart2 from './chart.vue'

    import VueAxios from 'vue-axios';
    import axios from 'axios';
    import BootstrapVue from 'bootstrap-vue';
    import Swal from 'sweetalert2'


    Vue.use(BootstrapVue);
    Vue.use(VueAxios, axios);


  export default {
    components: {
      LineChart,
      LineChart2,
      
    },
    data () {
      return {
        records : {},
        datacollection1: null,      
        datacollection4: null,
        datacollection6: null,
        voyages:'',
        reservationsConfirmes:'',
        reservationsAnnules:'',

        voyagesMois:'',
        locationsMois:'',
       
        voyagesMois3:'',

        retour : '',

        
        clients:'',
        locations:'',
        recettes:'0 XAF',
    
      }
    },
    mounted () {
      this.fillData1(),  
      this.fillData4(),
      this.fillData6(),
      this.voyages = this.countVoyages(),

    this.records = this.list(),
     this.countVoyagesMois('01'),
     this.countVoyagesMois('02'),
      this.voyagesMois3 = this.countVoyagesMois('03'),
      this.voyagesMois4 = this.countVoyagesMois('04'),
      this.voyagesMois5 = this.countVoyagesMois('05'),
      this.voyagesMois6 = this.countVoyagesMois('06'),
      this.voyagesMois7 = this.countVoyagesMois('07'),
      this.voyagesMois8 = this.countVoyagesMois('08'),
      this.voyagesMois9 = this.countVoyagesMois('09'),
      this.voyagesMois10 = this.countVoyagesMois('10'),
      this.voyagesMois11 = this.countVoyagesMois('11'),
      this.voyagesMois12 = this.countVoyagesMois('12'),
      
      this.reservationsConfirmes = this.countReservationsConfirmes(),
      this.reservationsAnnules = this.countReservationsAnnules(),
      
      this.clients = this.countClients(),
      this.locations = this.countLocations(),
      this.recettes = this.sommeRecette()

    },
    methods: {

         list()
            {
                let ar = this;
              
                axios.get('/voyages-client-jour')
                    .then(function(response){
                        records = response.data;
                        console.log(ar.records)
                    }).catch(
                    function(response){
                        console.log(response)
                    }
                );
            },

    
        countVoyages()
        {
               
                this.axios.get('/nombre-voyages')
                    .then((response) => {
                        this.voyages = response.data;
                    }).catch(err => console.log(err));
            },


            countVoyagesMois(id)
            {
              
               if(id=='01'){
                   this.axios.get('/voyageByMois/'+id)
                    .then((response) => {
                        this.voyagesMois1= response.data; 

                    }).catch(err => console.log(err));

               }else if (id=='02'){
                    this.axios.get('/voyageByMois/'+id)
                    .then((response) => {
                        this.voyagesMois2= response.data;
 

                    }).catch(err => console.log(err));

               }
               else if (id=='03'){
                    this.axios.get('/voyageByMois/'+id)
                    .then((response) => {
                        this.voyagesMois3= response.data;
 

                    }).catch(err => console.log(err));
                   
               }
               else if (id=='04'){
                    this.axios.get('/voyageByMois/'+id)
                    .then((response) => {
                        this.voyagesMois4= response.data;
 

                    }).catch(err => console.log(err));
                   
               }
                
              

            },


        countLocationsMois(id)
            {
               
                this.axios.get('/locationByMois/'+id)
                    .then((response) => {
                        this.locationsMois = response.data;                    
                    }).catch(err => console.log(err));
            },

        countReservationsConfirmes()
        {
               
                this.axios.get('/nombre-reservations-confirmes')
                    .then((response) => {
                        this.reservationsConfirmes = response.data;
                    }).catch(err => console.log(err));
            },
       
         countReservationsAnnules()
        {
               
                this.axios.get('/nombre-reservations-annules')
                    .then((response) => {
                        this.reservationsAnnules = response.data;
                    }).catch(err => console.log(err));
            },
        
        countClients()
        {
               
                this.axios.get('/nombre-clients')
                    .then((response) => {
                        this.clients = response.data;
                    }).catch(err => console.log(err));
            },

        countLocations()
        {
               
                this.axios.get('/nombre-locations')
                    .then((response) => {
                        this.locations = response.data;
                    }).catch(err => console.log(err));
            },

        
         sommeRecette()
        {
               
                this.axios.get('/total-recette-voyage')
                    .then((response) => {
                        this.recettes = response.data;
                    }).catch(err => console.log(err));
            },


      fillData1 () {
               


        this.datacollection1 = {
          labels: ['Janvier', 'Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Décembre'],
          datasets: [
            {
              label: 'Les Réservations  de cette année',
              backgroundColor: '#2ecc71',
                    data: [
                        this.voyagesMois         
                    ]            
                    }, 
                    {
              label: 'Les Locations de cette année',
              backgroundColor: '#3498db',
                    data: 
                    [
                      this.locationsMois                       
                    ]           
             }
          ]
        }
      },

    fillData4 () {
         this.countVoyagesMois('01'),
               
        console.log('ok' + this.voyagesMois1),


        this.datacollection4 = {
          labels: ['Janvier', 'Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Décembre'],
          datasets: [
            {
              label: 'Les Réservations de cette année',
              backgroundColor: '#2ecc71',
              data: [
                        this.getRandomInt(),this.getRandomInt()
                    ]
            }, 
          ]
        }
      },


      fillData6 () {
        this.datacollection6 = {
          labels: ['Janvier', 'Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Décembre'],
          datasets: [
            {
              label: 'Les Locations de cette année',
              backgroundColor: '#C239B3',
              data: 
                    [
                         
                    ]
            }, 
          ]
        }
      },

      getRandomInt () {
        return Math.floor(Math.random() * (500 - 5 + 1)) + 100
      }
    }
  }
</script>


<style>
  .small {
    max-width: 600px;
  }
</style>
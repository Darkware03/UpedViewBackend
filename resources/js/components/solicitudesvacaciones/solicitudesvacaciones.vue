<template>
<div class="container">
    <!--texto, titulo de la sugerencias antes de la tabla-->
    <!--<div class="red lighten-1 text-center">
        <span class="white--text">Sugerencias</span>
    </div>-->

    <!--Abre ventana de formulario para agregar un nuevo asunto-->
    <v-dialog v-model="modal" width="500">
        <v-card class="align-center">
            <v-card-title class="">Solicitud de vacaciones</v-card-title>
                <v-card >
                    <v-form class="pt-5 pr-11 pl-11 pt-5">

                       <v-row>
                            <v-date-picker v-model="date"  color="red lighten-1">
                              <v-spacer></v-spacer>
                            </v-date-picker>
                             <v-text-field
                                v-model="date"
                                label="Fecha de solicitud"
                                readonly
                              ></v-text-field>
                        </v-row>



                        <v-card-actions class="pb-4">
                            <v-spacer></v-spacer>
                            <v-btn color="red darken-1" @click="modal = false">Cancelar</v-btn>
                            <v-btn color="green darken-1"  @click="agregarSolicitudVacaciones">{{this.id == null?'Agregar':'Editar'}} Solicitud</v-btn>

                        </v-card-actions>
                    </v-form>
                </v-card>
        </v-card>
    </v-dialog>

    <!--buscador de las sugerencias-->
   <div class="row pb-4 ">
        <div class="col-3">
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Buscar solictud"
                single-line
                hide-details
            ></v-text-field>
        </div>

        <div class="col text-right">
          <!--  <v-btn
                outlined
                color="success"
                dark
                 @click.stop="modal = true">
                <v-icon>mdi-plus</v-icon>
                    Agregar
            </v-btn>-->
        </div>

    </div>


    <!--tabla-->
    <v-card>
        <v-data-table
            :search="search"
            :headers="headers"
            :items="solictudesRecibidas"
            :items-per-page="10"
        >

        </v-data-table>

    </v-card>
</div>
</template>

<script>
    export default {


        data(){

            return{

                  //iniciando valores
                    search:null,
                    modal:false,
                    id:null,
                    Users:null,
                    date: new Date().toISOString().substr(0, 10),



                    //contenido que mostrara la tabla
                    solictudesRecibidas:[],
                    headers:[
                        {
                        text:'Hecha por:',
                        value:'Users'
                    },
                     {
                        text:'Mensaje:',
                        value:'mensaje'
                    },
                     {
                        text:'Fecha de inicio de vacacion:',
                        value:'fecha_inicio'
                    },
                    {
                        text:'Solictud hecha el dia:',
                        value:'created_at'
                    },

                    ],



                };
        },


        methods: {
            agregarSolicitudVacaciones() {
                axios.post("api/SolicitudesVacaciones/postsolicitudvacacion", {
                        id:this.id,
                        Users:this.Users,
                        fecha_inicio:this.date,
                    })
                    .then(response => {

                        this.limpiar()
                        this.obtenerSolicitudes()
                        modal = false
                    })
            },

            limpiar(){
                this.date=null;
                this.Users=null;
            },

            obtenerSolicitudes(){
                axios.post('api/SolicitudesVacaciones/getsolicitudesvacaciones')
                    .then((response) => {
                        this.solictudesRecibidas = response.data
                        modal = false

                    })
            },


        },

        mounted(){
            this.obtenerSolicitudes()
            console.log(this.id)
        }
    };
</script>



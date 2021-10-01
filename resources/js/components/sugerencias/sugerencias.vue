<template>
<div class="container">
    <!--texto, titulo de la sugerencias antes de la tabla-->
    <!--<div class="red lighten-1 text-center">
        <span class="white--text">Sugerencias</span>
    </div>-->

    <!--Abre ventana de formulario para agregar un nuevo asunto-->
    <!--<v-dialog v-model="modal" width="500">
        <v-card class="align-center">
            <v-card-title class="">Registrar sugerencia</v-card-title>
                <v-card >
                    <v-form
                        class="pt-5 pr-11 pl-11 pt-5">
                        <v-text-field
                            label="Descripcion de la sugerencia"
                            v-model="descripcion"
                            required
                        ></v-text-field>

                                    
                        <v-card-actions class="pb-4">
                            <v-spacer></v-spacer>
                            <v-btn color="red darken-1" @click="modal = false">Cancelar</v-btn>
                            <v-btn color="green darken-1"  @click="agregarSugerencia">{{this.id == null?'Agregar':'Editar'}} Asunto</v-btn>

                        </v-card-actions>
                    </v-form>
                </v-card>
        </v-card>
    </v-dialog>-->

    <!--Tabla para mostrar los datos de los usuarios registrados-->
   <!-- <div class="row pb-4 ">
        <div class="col-3">
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Buscar"
                single-line
                hide-details
            ></v-text-field>
        </div>
        <div class="col text-right">
            <v-btn
                outlined
                color="success"
                dark
                 @click.stop="modal = true">
                <v-icon>mdi-plus</v-icon>
                    Agregar Asunto
            </v-btn>
        </div>

    </div>-->


    <!--buscador de las sugerencias-->
    <div class="row pb-4 ">
        <div class="col-3">
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Buscar sugerencia"
                single-line
                hide-details
            ></v-text-field>
        </div>

    </div>
    <!--tabla-->
    <v-card>
        <v-data-table
            :search="search"
            :headers="headers"
            :items="sugerenciasRecibidas"
            :items-per-page="10"
        >

        </v-data-table>
        
    </v-card>
</div>
</template>

<script>
    export default {
        data() {

            return {
                //iniciando valores
                search:null,
                modal:false,
                id:null,
                descripcion:null,
                Users:null,
                
                
                //contenido que mostrara la tabla
                sugerenciasRecibidas:[],
                headers:[
                    {
                    text:'Hecha por:',
                    value:'Users'
                },
                    {
                    text:'Sugerencia',
                    value:'descripcion'
                },

                {
                    text:'Fecha de la sugerencia',
                    value:'created_at'
                },
                
                ],
            };
        },
        methods: {
             agregarSugerencia() {
                axios.post("api/Sugerencias/postsugerencia", {
                        id:this.id,
                        descripcion:this.descripcion,
                        Users:this.Users,
                    })
                    .then(response => {
                        
                        this.limpiar()
                        this.obtenerSugerencias()
                    })
            },

            limpiar(){
                this.descripcion=null;
                this.Users=null;
            },
            obtenerSugerencias(){
                axios.post('api/Sugerencias/getsugerencias')
                    .then((response) => {
                        this.sugerenciasRecibidas = response.data
                       
                    })
            },
  
            
        },
        mounted(){
            this.obtenerSugerencias()
            console.log(this.id)
        }
    };
</script>



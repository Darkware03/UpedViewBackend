<template>
<div class="container">
    <!--Abre ventana de formulario para agregar un nuevo usuario-->
    <v-dialog v-model="modal" width="500">
        <v-card class="align-center">
            <v-card-title class="">Nuevo Correo</v-card-title>
                <v-card >
                    <v-form
                        class="pt-5 pr-11 pl-11 pt-5">
                        
                        <v-text-field
                            label="Para:"
                            v-model="correoDestinatario"
                            emailRules
                            required
                        ></v-text-field>

                        <v-select
                            label="Asunto"
                            v-model="Asunto"
                            :items="asuntosRecibidos"
                            item-text="descripcion"
                            item-value="id"
                        ></v-select>
                        <v-textarea
                            label="Mensaje"
                            v-model="mensaje"
                            outlined
                          ></v-textarea>

                        <v-card-actions class="pb-4">
                            <v-spacer></v-spacer>
                            <v-btn color="red darken-1" @click="modal = false">Cancelar</v-btn>
                            <v-btn color="green darken-1"  @click="agregarCorreoPersonal">Enviar correo</v-btn>
                        </v-card-actions>
                    </v-form>
                </v-card>
        </v-card>
        
    </v-dialog>

    <!--Tabla para mostrar los datos de los usuarios registrados-->
        <div class="row pb-4 ">
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
                    Nuevo Correo
                </v-btn>
            </div>
        </div>

        <v-card class="pt-9">
            <v-data-table
                :search="search"
                :headers="headers"
                :items="correosPersonalesRecibidos"
                :items-per-page="10"
            >
           
                      
           <!--<template v-slot:item.eliminar="{item}">
                <v-btn text color="red darken-1" @click="eliminarCorreoPersonal(item)">
                    <v-icon>mdi-minus</v-icon>
                </v-btn>
            </template>-->
            </v-data-table>
        </v-card>

    
</div>
</template>

<script>
    export default {
        data() {

            return {
                search:null,
                modal:false,

                //inicialisando los valores
                id:null,
                correoDestinatario:null,
                Asunto:null,
                mensaje:null,
                asuntosRecibidos:[],

                
                //contenido que mostrara la tabla
                correosPersonalesRecibidos:[],
                headers:[
                {
                    text:'De:',
                    value:'correo_remitente'
                },
                {
                    text:'Para:',
                    value:'correo_destinatario'
                },
                {
                    text:'Asunto',
                    value:'Asunto'
                },
                {
                    text:'Mensaje',
                    value:'mensaje'
                },
                {
                    text:'Fecha de envio',
                    value:'created_at'
                },

                /*{
                    text:'Editar',
                    value:'editar'
                },

                {
                    text:'Eliminar',
                    value:'eliminar'
                },*/
                
                ],
            };
        },
        methods: {

            agregarCorreoPersonal() {
                axios.post("api/CorreosPersonales/postcorreopersonal", {
                        id:this.id,
                        correoDestinatario:this.correoDestinatario,
                        Asunto:this.Asunto,
                        mensaje:this.mensaje,

                    })
                    .then(response => {
                        this.modal=false
                        this.limpiar()
                        this.obtenerCorreoPersonal()
                    })
                    

            },

            obtenerCorreoPersonal(){
                axios.post('api/CorreosPersonales/getcorreospersonales')
                    .then((response) => {
                        this.correosPersonalesRecibidos = response.data.data
                        this.asuntosRecibidos = response.data.data2
                    })
            },

             limpiar(){
                this.correoDestinatario=null;
                this.Asunto=null;
                this.mensaje=null;
            },

            /*editarCorreoPersonal(item){
                this.modal=true
                this.id=item.id;
                this.descripcion=item.descripcion;
            },
            

            eliminarCorreoPersonal(item){
                    this.$swal.fire({
                        title: '¿¿Estas seguro??',
                        text: "No podras revertir esta accion!",
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, borrar!',
                        showCancelButton: true
                    }).then((result) => {
                            if (result.value) {
                                axios.post('api/CorreosPersonales/deletecorreopersonal',{id:item.id})
                                .then((response) => {
                                    this.$swal.fire(
                                        '¡Borrado!',
                                        'Correo Eliminado',
                                        'success'
                                    )
                                   
                                });
                            }
                    });

            }*/
        },
        mounted(){
            this.obtenerCorreoPersonal()
            console.log(this.id)
        }
    };
</script>
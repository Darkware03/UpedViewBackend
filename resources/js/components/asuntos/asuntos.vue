<template>
<div class="container">
    <!--Abre ventana de formulario para agregar un nuevo asunto-->
    <v-dialog v-model="modal" width="500">
        <v-card class="align-center">
            <v-card-title class="">Registrar Asunto</v-card-title>
                <v-card >
                    <v-form
                        class="pt-5 pr-11 pl-11 pt-5">
                        <v-text-field
                            label="Descripcion del asunto"
                            v-model="descripcion"
                            required
                        ></v-text-field>
                                    
                        <v-card-actions class="pb-4">
                            <v-spacer></v-spacer>
                            <v-btn color="red darken-1" @click="modal = false">Cancelar</v-btn>
                            <v-btn color="green darken-1"  @click="agregarAsunto">{{this.id == null?'Agregar':'Editar'}} Asunto</v-btn>

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
                    Agregar Asunto
            </v-btn>
        </div>

    </div>
    <!--tabla-->
    <v-card>
        <v-data-table
            :search="search"
            :headers="headers"
            :items="asuntosRecibidos"
            :items-per-page="5"
        >
                      
        <template v-slot:item.editar="{item}">
            <v-btn text color="yellow darken-1"  @click="editarAsunto(item)">
            <v-icon>mdi-pencil</v-icon>
            </v-btn>
        </template>
        <template v-slot:item.eliminar="{item}">
            <v-btn text color="red darken-1" @click="eliminarAsunto(item)">
            <v-icon>mdi-minus</v-icon>
            </v-btn>
        </template>

        </v-data-table>
        <v-dialog v-model="alert">
                <v-card>
                    <v-card>
                        <div class="text-h6">Alert</div>
                    </v-card>

                    <v-card class="q-pt-none">
                        ¿Está seguro que quiere eliminar el asunto?
                    </v-card>

                    <v-btn  color="warning" @click="alert=false" >NO, eliminar</v-btn>
                    <v-btn   color="danger" @click="cambiarconfirm">Sí, eliminar</v-btn>
                </v-card>
            </v-dialog>
    </v-card>
</div>
</template>

<script>
    export default {
        data() {

            return {
                alert:false,
                search:null,
                modal:false,

                //inicialisando los valores
                id:null,
                descripcion:null,
                
                //contenido que mostrara la tabla
                asuntosRecibidos:[],
                headers:[
                    {
                    text:'Descripcion',
                    value:'descripcion'
                },

                {
                    text:'Editar',
                    value:'editar'
                },

                {
                    text:'Eliminar',
                    value:'eliminar'
                },
                
                ],
            };
        },
        methods: {

            agregarAsunto() {
                axios.post("api/Asuntos/postasunto", {
                        id:this.id,
                        descripcion:this.descripcion,
                    })
                    .then(response => {
                        
                        this.limpiar()
                        this.obtenerAsuntos()
                    })
                    

            },

            obtenerAsuntos(){
                axios.post('api/Asuntos/getasuntos')
                    .then((response) => {
                        this.asuntosRecibidos = response.data
                    })
            },

             limpiar(){
                this.descripcion=null;
            },

            editarAsunto(item){
                this.modal=true
                this.id=item.id;
                this.descripcion=item.descripcion;
            },
            
            cambiarconfirm(){
                    this.confirm=true
                },

            eliminarAsunto(item){
                    this.$swal.fire({
                        title: '¿¿Estas seguro??',
                        text: "No podras revertir esta accion!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, borrar!'
                    }).then((result) => {
                            if (result.value) {
                                axios.post('api/Asuntos/deleteasunto', {
                                    id: item.id
                                }).then((response) => {
                                    this.$swal.fire(
                                        '¡Borrado!',
                                        'Asunto Eliminado',
                                        'success'
                                    )
                                    this.obtenerAsuntos()
                                });
                            }
                    });

                }
        },
        mounted(){
            this.obtenerAsuntos()
            console.log(this.id)
        }
    };
</script>

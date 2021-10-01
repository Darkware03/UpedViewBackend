<template>
    <div class="container">


        <v-dialog  v-model="modal" width="500" persistent>
            <v-card class="pt-4 pl-7 pr-7">
                <v-card-title>
            <span class="headline">Agregue una nueva categoría:</span>
            </v-card-title>
            <v-form class="pt-7 pr-11 pl-11 pt-7">
                <v-text-field
                        v-model="descripcion"
                        label="Nombre de la categoría"
                        placeholder="campo requerido *"
                        required
                ></v-text-field>


                <v-card-actions class="pb-4">
                    <v-spacer></v-spacer>
                    <v-btn color="red darken-1" text @click="limpiar">Close</v-btn>
                <v-btn
                color="success"
                @click="enviarCatPub">{{this.id == null?'Agregar':'editar'}}
                Categoría
                </v-btn>
                </v-card-actions>

            </v-form>
            </v-card>
        </v-dialog>

            <v-btn
                    outlined
                    color="success"
                    dark
                    @click.stop="modal = true">
                Agregar Categoría Publicación
            </v-btn>

        <v-card class="pt-9">

                <v-data-table
                    :headers="headers"
                    :items="catpubsRecibidas"
                    :items-per-page="5"
                    class="elevation-1">
                <template v-slot:item.editar="{item}">
                    <v-btn text color="blue darken-1" @click="editar(item)">
                        <v-icon>mdi-pencil</v-icon>
                    </v-btn>
                </template>
                <template v-slot:item.eliminar="{item}">
                    <v-btn text color="red darken-1" @click="eliminar(item)">
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
                        ¿Está seguro que quiere eliminar?
                    </v-card>

                    <v-btn   color="danger" @click="cambiarconfirm">Sí, eliminar</v-btn>
                    <v-btn  color="warning" @click="alert=false" >NO, eliminar</v-btn>
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
                    confirm:false,
                    id:null,
                    modal:false,
                    descripcion:null,
                    catpubsRecibidas:[],
                    headers:[
                        {
                            text:'descripcion',
                            value:'descripcion'
                         },
                        {
                            text:'fecha creacion',
                            value:'created_at'
                        },
                        {
                            text:'fecha modificacion',
                            value:'updated_at'
                        },
                        {
                            text:'editar',
                            value:'editar'
                        },
                        {
                            text:'eliminar',
                            value:'eliminar'
                        },


                    ],            }
            },
            methods:{
                cambiarconfirm(){
                    this.confirm=true
                },
                enviarCatPub(){
                    if (this.descripcion!==null && this.descripcion!==''){
                        axios.post('api/CategoriaPublicacion/postcatpub',{
                            id:this.id,
                            descripcion:this.descripcion
                        }).then((response) => {
                            this.modal=false
                            this.limpiar()
                            this.recibirCatPub()
                        }).then((response) => {
                            this.$swal.fire(
                                '¡Exitoso!',
                                'Guardado',
                                'success'
                            )
                            this.recibirCatPub()
                        });
                    }else {
                        this.$swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Llene todos los campos!'
                        })
                    }
                },
                recibirCatPub(){
                    axios.post('api/CategoriaPublicacion/getcatpub')
                        .then((response) => {
                            this.catpubsRecibidas = response.data
                        })
                },
                editar(item){
                    this.modal=true;
                    this.id=item.id;
                    this.descripcion=item.descripcion;
                },
                limpiar(){
                    this.modal=false;
                    this.descripcion=null;
                },
                eliminar(item){
                    this.$swal.fire({
                        title: '¿Está seguro?',
                        text: "¡No podrá revertir esta acción!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, borrar!'
                    }).then((result) => {
                            if (result.value) {
                                axios.post('api/CategoriaPublicacion/eliminarcatpub', {
                                    id: item.id
                                }).then((response) => {
                                    this.$swal.fire(
                                        '¡Eliminado!',
                                        '¡Categoría Eliminada',
                                        'success'
                                    )
                                    this.recibirCatPub()
                                });
                            }
                    });

                }
            },
            mounted() {
                this.recibirCatPub()
            }
        }
    </script>

    <style scoped>

    </style>

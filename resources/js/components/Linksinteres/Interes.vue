<template>
    <div class="container">


        <v-dialog  v-model="modal" width="500" persistent>
            <v-card class="pt-4 pl-7 pr-7">
                <v-card-title>
            <span class="headline">Agregue un Link de Interés</span>
            </v-card-title>
            <v-form class="pt-7 pr-11 pl-11 pt-7">
                <v-text-field
                        v-model="titulo"
                        label="Título"
                        required
                ></v-text-field>
                <v-text-field
                        v-model="link"
                        label="Ingrese una URL"
                        required
                ></v-text-field>


                <v-card-actions class="pb-4">
                    <v-spacer></v-spacer>
                    <v-btn color="red darken-1" text @click="limpiar">Close</v-btn>
                <v-btn
                color="success"
                @click="enviarDatosLi">{{this.id == null?'Agregar':'editar'}}
                Link
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
                Agregar Link
            </v-btn>

        <v-card class="pt-9">

                <v-data-table
                    :headers="headers"
                    :items="linksRecibidos"
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
                    titulo:null,
                    link:null,
                    linksRecibidos:[],
                    headers:[
                        {
                            text:'Título',
                            value:'titulo'
                         },
                         {
                            text:'Link',
                            value:'link'
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
                enviarDatosLi(){
                    if (this.titulo!==null && this.titulo!=='' && this.link!==null && this.link!=='') {
                        axios.post('api/LinkInteres/postli',
                            {
                                id: this.id,
                                titulo: this.titulo,
                                link: this.link

                            }).then((response) => {
                            this.modal = false
                            this.limpiar()

                        }).then((response) => {
                            this.$swal.fire(
                                '¡Exitoso!',
                                'Guardado',
                                'success'
                            )
                            this.recibirLis()
                        });
                    }else {
                        this.$swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Llene todos los campos!'
                        })
                    }
                },
                recibirLis(){
                    axios.post('api/LinkInteres/getli')
                        .then((response) => {
                            this.linksRecibidos = response.data
                        })
                },
                editar(item){
                    this.modal=true;
                    this.id=item.id;
                    this.titulo=item.titulo;
                    this.link=item.link;
                },
                limpiar(){
                    this.modal=false;
                    this.titulo=null;
                    this.link=null;
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
                                axios.post('api/LinkInteres/eliminarli', {
                                    id: item.id
                                }).then((response) => {
                                    this.$swal.fire(
                                        '¡Eliminado!',
                                        'Link Eliminado',
                                        'success'
                                    )
                                    this.recibirLis()
                                });
                            }
                    });

                }
            },
            mounted() {
                this.recibirLis()
            }
        }
    </script>

    <style scoped>

    </style>

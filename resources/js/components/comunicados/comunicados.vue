<template>
    <div class="container">


        <v-dialog  v-model="modal" width="500" persistent>
            <v-card class="pt-4 pl-7 pr-7">
                <v-card-title>
            <span class="headline">Agregue los datos del comunicado</span>
            </v-card-title>
            <v-form class="pt-7 pr-11 pl-11 pt-7">
                <v-text-field
                        v-model="titulo"
                        label="Titulo"
                        required
                ></v-text-field>

                <v-text-field
                        v-model="texto"
                        label="Comunicado"
                        required
                ></v-text-field>
                <v-select
                        label="categoria"
                        outlined
                        v-model="categoria"
                        :items="catComunicados"
                        item-text="descripcion"
                        item-value="id"
                />


                <v-card-actions class="pb-4">
                    <v-spacer></v-spacer>
                    <v-btn color="red darken-1" text @click="limpiar">Close</v-btn>
                <v-btn
                color="success"
                @click="enviarDatosComunicado">{{this.id == null?'Agregar':'editar'}}
                Comunicado
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
                Agregar comunicado
            </v-btn>

        <v-card class="pt-9">

            <v-data-table
                    :headers="headers"
                    :items="comunicadosRecibidos"
                    :items-per-page="5"
                    class="elevation-1"
            >
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
        </v-card>
    </div>
    </template>

    <script>
        export default {
            data() {
                return {
                    categoria:null,
                    confirm:false,
                    id:null,
                    modal:false,
                    titulo:null,
                    texto:null,
                    comunicadosRecibidos:[],
                    headers:[{
                        text:'titulo',//esto es como se llamara el encabezado
                        value:'titulo'//esto es lo que llenara ese encabezado
                         },
                        {
                            text:'texto',
                            value:'texo_comunicado'
                        },
                        {
                            text:'descripcion',
                            value:'descripcion',
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
                enviarDatosComunicado(){
                    if (this.categoria !==null && this.categoria!=='' && this.titulo!==null && this.titulo!==''
                    && this.texto!==null && this.texto!=='' && this.categoria!==null && this.categoria!=='') {
                        axios.post('api/Comunicados/postcomunicados', {
                            id: this.id,
                            titulo: this.titulo,
                            texto: this.texto,
                            categoria: this.categoria
                        }).then((response) => {
                            this.modal = false
                            this.limpiar()
                        }).then((response) => {
                            this.$swal.fire(
                                '¡Exitoso!',
                                'Guardado',
                                'success'
                            )
                            this.recibirComunicados()
                        });
                    }else{
                        this.$swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Llene todos los campos!'
                        })
                    }
                },
                recibirComunicados(){
                    axios.post('api/Comunicados/getcomunicados')
                        .then((response) => {
                            this.comunicadosRecibidos = response.data.data
                            this.catComunicados = response.data.data2
                        })
                },
                editar(item){
                    this.modal=true;
                    this.id=item.id;
                    this.categoria=item.tipo_comunicado;
                    this.titulo=item.titulo;
                    this.texto=item.texo_comunicado;
                },
                limpiar(){
                    this.modal=false;
                    this.titulo=null;
                    this.texto=null;
                    this.categoria=null;
                },
                eliminar(item){
                    this.$swal.fire({
                        title: 'Estas seguro??',
                        text: "No podras revertir esta accion!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, borrar!'
                    }).then((result) => {
                            if (result.value) {
                                axios.post('api/Comunicados/elimarcomunicados', {
                                    id: item.id
                                }).then((response) => {
                                    this.$swal.fire(
                                        '¡Borrado!',
                                        'Comunicado Eliminado',
                                        'success'
                                    )
                                    this.recibirComunicados()
                                });
                            }
                    });

                }
            },
            mounted() {
                this.recibirComunicados()
            }
        }
    </script>

    <style scoped>

    </style>

<template>
    <div class="container">


        <v-dialog  v-model="modal" width="500" persistent>
            <v-card class="pt-4 pl-7 pr-7">
                <v-card-title>
                    <span class="headline">Agregar Nuevo Album</span>
                </v-card-title>
                <v-form class="pt-7 pr-11 pl-11 pt-7">
                    <v-text-field
                            v-model="titulo"
                            label="Nombre album"
                            required
                    ></v-text-field>
                    <v-card-actions class="pb-4">

                        <v-btn
                                color="success"
                                @click="enviarDatosLi">{{this.id == null?'Agregar':'editar'}}
                            Album
                        </v-btn>
                        <v-btn
                                color="warning"
                                @click="limpiar">Cancelar</v-btn>
                    </v-card-actions>

                </v-form>
            </v-card>
        </v-dialog>

        <v-btn
                outlined
                color="success"
                dark
                @click.stop="modal = true">
            Agregar Album
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
                items:[],
                modal:false,
                titulo:null,
                linksRecibidos:[],
                headers:[
                    {
                        text:'Nombre',
                        value:'nombre_album'
                    },
                    {
                        text:'fecha creacion',
                        value:'created_at'
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
                axios.post('api/Galeria/postalbum',
                    {
                        id:this.id,
                        titulo:this.titulo,

                    }).then((response) => {
                    this.modal=false
                    this.limpiar()
                }).then((response) => {
                                    this.$swal.fire(
                                        '¡Exitoso!',
                                        'Guardado',
                                        'success'
                                    )
                                    this.recibirLis()
                                });
            },
            recibirLis(){
                axios.post('api/Galeria/getAlbum')
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
                this.id=null;
                this.titulo=null;
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
                        axios.post('api/Galeria/deletealbum', {
                            id: item.id
                        }).then((response) => {
                            this.$swal.fire(
                                '¡Eliminado!',
                                'Album Eliminado',
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

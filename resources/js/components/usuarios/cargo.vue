<template>
    <div class="container">


        <v-dialog  v-model="modal" width="500" persistent>
            <v-card class="pt-4 pl-7 pr-7">
                <v-card-title>
                    <span class="headline">Agregue Nuevo Cargo</span>
                </v-card-title>
                <v-form class="pt-7 pr-11 pl-11 pt-7">
                    <v-text-field
                        v-model="cargo"
                        label="Cargo"
                        required
                    ></v-text-field>
                    <v-card-actions class="pb-4">

                        <v-btn
                            color="success"
                            @click="enviarDatos">{{this.id == null?'Agregar':'editar'}}
                            Cargo
                        </v-btn>
                        <v-btn
                            color="danger"
                            @click="limpiar">
                            Cerrar
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
            Agregar cargo
        </v-btn>

        <v-card class="pt-9">

            <v-data-table
                :headers="headers"
                :items="cargos"
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
                cargos:[],
                headers:[
                    {
                        text:'cargo',
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


                ],
            }
        },
        methods:{
            cambiarconfirm(){
                this.confirm=true
            },
            enviarDatos(){
                if (this.cargo!==null && this.cargo!=='') {
                    axios.post('api/Usuarios/postCargo', {
                        id: this.id,
                        cargo: this.cargo,
                    }).then((response) => {
                        this.$swal.fire(
                            '¡Exitoso!',
                            'Guardado',
                            'success'
                        )
                        this.limpiar()
                        this.recibirCargo()
                    })
                }else{
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Llene todos los campos!'
                    })
                }
            },
            recibirCargo(){
                axios.post('api/Usuarios/getCargo')
                    .then((response) => {
                        this.cargos = response.data
                    })
            },
            editar(item){
                this.modal=true;
                this.id=item.id;
                this.cargo=item.descripcion;
            },
            limpiar(){
                this.modal=false;
                this.id=null;
                this.cargo=null;
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
                        axios.post('api/Usuarios/deleteCargo', {
                            id: item.id
                        }).then((response) => {
                            this.$swal.fire(
                                '¡Borrado!',
                                'Comunicado Eliminado',
                                'success'
                            )
                            this.recibirCargo()
                        });
                    }
                });

            }
        },
        mounted() {
            this.recibirCargo()
        }
    }
</script>

<style scoped>

</style>

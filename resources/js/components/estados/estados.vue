<template>




    <v-container>
      <v-row dense>
        <v-col cols="12">
          <v-card
            color="#444449"
            dark
          >
            <v-card-title class="headline">Estados</v-card-title>

            <v-data-table
                    :headers="headers"
                    :items="estadosRecibidos"
                    class="elevation-1"
            >
            </v-data-table>

          </v-card>
        </v-col>
      </v-row>

        <v-row dense>
            <v-col cols="12">
                <v-card
                    color="#444449"
                    dark
                >
                    <v-card-title class="headline">Categoria de Comunicados</v-card-title>

                    <v-data-table
                        :headers="headers2"
                        :items="comunicadosCat"
                        class="elevation-1"
                    >
                    </v-data-table>

                </v-card>
            </v-col>
        </v-row>

        <v-row dense>
            <v-col cols="12">
                <v-card
                    color="#444449"
                    dark
                >
                    <v-card-title class="headline text-center">Tipos de Marcacion</v-card-title>

                    <v-data-table
                        :headers="headers3"
                        :items="marcacionTipos"
                        class="elevation-1 text-center"
                    >
                    </v-data-table>

                </v-card>
            </v-col>
        </v-row>
    </v-container>


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
                    estadosRecibidos:[],
                    comunicadosCat:[],
                    marcacionTipos:[],
                    headers:[{
                        text:'Descripción del Estado:',//esto es como se llamara el encabezado
                        value:'descripcion'//esto es lo que llenara ese encabezado
                         },
                        {
                            text:'Fecha de Emisión:',
                            value:'created_at'
                        },

                    ],
                    headers2:[{
                        text:'Tipo de Comunicado:',//esto es como se llamara el encabezado
                        value:'descripcion'//esto es lo que llenara ese encabezado
                         },
                        {
                            text:'Fecha de:',
                            value:'created_at'
                        },

                    ],
                    headers3:[{
                        text:'Tipo de Marcacion:',//esto es como se llamara el encabezado
                        value:'descripcion'//esto es lo que llenara ese encabezado
                         }
                    ],
                }
            },
            methods:{
                cambiarconfirm(){
                    this.confirm=true
                },
                enviarDatosEstado(){
                    axios.post('api/Estados/postestados',{
                        id:this.id,
                        descripcion:this.descripcion,

                    }).then((response) => {
                        this.modal=false
                        this.limpiar()
                        this.recibirEstados()
                    })
                },
                recibirEstados(){
                    axios.post('api/Estados/getestados')
                        .then((response) => {
                            this.estadosRecibidos = response.data
                        })
                },
                recibirMarcacion(){
                    axios.post('api/Estados/getMarcacion')
                        .then((response) => {
                            this.marcacionTipos = response.data
                        })
                },
                recibirComunicadosCat(){
                    axios.post('api/Comunicados/getcomunicados')
                        .then((response) => {
                            this.comunicadosCat = response.data.data2
                        })
                },
                editar(item){
                    this.modal=true;
                    this.id=item.id;
                    this.descripcion=item.descripcion;

                },
                limpiar(){
                    this.titulo=null;
                    this.texto=null;
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
                                axios.post('api/Estados/eliminarestados', {
                                    id: item.id
                                }).then((response) => {
                                    this.$swal.fire(
                                        '¡Borrado!',
                                        'Comunicado Eliminado',
                                        'success'
                                    )
                                    this.recibirEstados()
                                });
                            }
                    });

                }
            },
            mounted() {
                this.recibirEstados()
                this.recibirComunicadosCat()
                this.recibirMarcacion()
            }
        }
    </script>

    <style scoped>

    </style>

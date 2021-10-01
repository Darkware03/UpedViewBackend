<template>
    <div class="container">
        <v-dialog
                persistent
                v-model="modal" width="500">
            <v-card class="align-center">
                <v-card-title class="">Cargar Video</v-card-title>
                            <v-card >
                                <v-form
                                        class="pt-7 pr-11 pl-11 pt-7">

                                    <v-text-field
                                            label="Titulo"
                                            v-model="titulo"
                                            required
                                            placeholder="ingrese titulo *requerido"
                                    ></v-text-field>

                                    <v-textarea
                                        required
                                            outlined
                                            label="Descripcion del video...."
                                            v-model="texto"
                                            placeholder="ingrese texto *requerido"
                                    ></v-textarea>
                                    <!--
                                    Aqui estara un dialog por si la validacion esta mala
                                    -->
                                    <v-dialog
                                            overlay-color="red"
                                            v-model="alerta"
                                            max-width="290"
                                    >
                                        <v-card>
                                            <v-card-title class="headline">Error</v-card-title>

                                            <v-card-text>
                                                Verifique si ha llenado los campos requeridos
                                            </v-card-text>

                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                        color="red darken-1"
                                                        text
                                                        @click="alerta = false"
                                                >
                                                    Entendido
                                                </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                    <v-file-input
                                            prepend-icon="mdi-video"
                                            v-model="files"
                                            color="lgrey darken-3"
                                            counter
                                            label="Video"
                                            multiple
                                            outlined
                                            v-if="id==null"
                                    />
                                    <div v-if="imagen">
                                        <v-img :src="imagen" />
                                    </div>
                                    <br>
                                    <v-select
                                            label="Facultad"
                                            outlined
                                            v-model="categoria"
                                            :items="catpubsRecibidas"
                                            item-text="descripcion"
                                            item-value="id"

                                    >
                                    </v-select>
                                    <v-card-actions class="pb-4">
                                        <v-spacer></v-spacer>
                                        <v-btn color="red darken-1" text @click="limpiar">Close</v-btn>
                                        <v-btn color="green darken-1" text @click="validacion">Publicar</v-btn>
                                    </v-card-actions>
                                </v-form>
                            </v-card>

                </v-card>
        </v-dialog>

        <div class="row pb-4 ">
            <div class="col-3">
                <v-text-field
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Search"
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
                    Agregar
                </v-btn>
            </div>
        </div>
        <v-card>
                    <v-data-table
                            :calculate-widths="true"
                            :search="search"
                            :headers="headers"
                            :items="publicaciones"
                            :items-per-page="5"
                    >
                       <!-- <template v-slot:item.imagen="{item}">
                            <v-img :src="item.imagen" width="125px"/>
                        </template>-->
                        <template v-slot:item.editar="{item}">
                            <v-btn text color="yellow darken-1"  @click="modificar(item)">
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
                search:null,
                id:null,
                modal:false,
                items:[],
                headers:[{
                    text:'titulo',
                    value:'titulo'
                },
                    {
                    text:'texto',
                    value:'publicacion_texto',
                    },
                    {
                    text:'Categoria',
                    value:'Categoria'
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
                modalImg:false,
                files: null,
                titulo: null,
                texto: null,
                categoria: null,
                alerta:false,
                publicaciones:[],
                path:null,
                imagen:null,
                catpubsRecibidas:[]
            };
        },
        methods: {
            enviarDatos() {
                /*
                  Primeramente inicializamos FormData
                  */
                let formData = new FormData();
                //validamos si el vmodel no esta vacio para ejecutar el foreach
                if (this.files !==null){
                    /*
              Iterar sobre cualquier archivo enviado anexando los archivos a los datos del formulario.
                 */

                    for (var i = 0; i < this.files.length; i++) {
                        let file = this.files[i];

                        formData.append("files[" + i + "]", file);
                    }
                }

                //validamos que los otros campos esten llenos

                //cuando enviemos imagenes no podremos hacerlo de forma convencional para enviar data en este caso
                //usaremos el maravilloso formData.append de js y le añadiremos asi
                //'Como quiero recibirlo en el controller',valor que tendra
                formData.append('titulo',this.titulo)
                formData.append('texto',this.texto)
                formData.append('categoria',this.categoria)
                if (this.id !==null){
                    formData.append('id',this.id)

                }
                //este aun no porque no esta la tabla formData.append('categoria',this.categoria)
                /*
                   Realice la solicitud a la URL POST

                  */
                //formData es la variable declarada arriba con let en este caso la enviaremos asi
                axios.post("api/Publicaciones/postPublicaciones",formData, {
                        headers: {
                            "Content-Type": "multipart/form-data"
                        },
                    })
                    .then(response => {
                        this.$swal.fire(
                            '¡Exitoso!',
                            'Guardado',
                            'success'
                        )
                        this.limpiar()
                        this.getFiles()
                    })
                    .catch(function(e) {
                        console.log(e);
                    });

            },
            validacion() {
                if (this.titulo !== "" && this.texto !== ""  && this.titulo !== null && this.texto !== null) {
                    this.enviarDatos();
                    this.modal=false
                } else {
                    this.alerta = true;
                }
            },
            getFiles(){
                let me=this;
                axios.post('api/Publicaciones/getPublicaciones')
                    .then(function (response) {
                        me.publicaciones=response.data.data
                        me.catpubsRecibidas=response.data.data2
                        console.log(response.data.data2)

                    })
            },
            limpiar(){
                this.modal=false
                this.texto=null;
                this.titulo=null;
                this.files=null;
                this.id=null;
                this.categoria=null;
                this.imagen=null;
            },
            modificar(item){
                this.modal=true
                this.id=item.id
                this.texto=item.publicacion_texto;
                this.titulo=item.titulo;
                this.categoria=item.idcat;
                this.imagen=item.imagen;
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
                        axios.post('api/Publicaciones/delPublicaciones',{id:item.id})
                            .then(response => {
                                this.limpiar()
                                this.getFiles()
                                this.$swal.fire(
                                    '¡Borrado!',
                                    'Eliminado exitosamente',
                                    'success'
                                )
                            })
                    }
                });
            },
        },
        mounted(){
            this.getFiles()
        }
    };
</script>

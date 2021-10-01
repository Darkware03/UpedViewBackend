<template>
    <v-card class="mx-5 my-12">

        <v-alert v-if="this.alerta==true" type="error" class="py-2" outlined prominent border="left">
            Error no ha seleccionado archivos
            <v-btn @click="alerta=!alerta" text small>Cerrar</v-btn>
        </v-alert>
       <v-dialog v-model="modal" persistent width="500">
           <v-card class="pt-4 pl-7 pr-7">
               <v-select
                       label="seleccione album"
                       v-model="album"
                       :items="albumes"
                       item-value="id"
                       item-text="nombre_album"
                       onchange="validarSelectAlbum"
               />
               <div v-if="album!==null">
                   <v-row>
                       <v-col>
                           <v-file-input
                                   accept="image/*"
                                   v-model="files"
                                   color="lgrey darken-3"
                                   counter
                                   label="Archivos"
                                   multiple
                                   placeholder="Seleccione sus archivos"
                                   prepend-icon="mdi-paperclip"
                                   outlined
                                   :show-size="1000"
                           >
                               <template v-slot:selection="{ index, text }" v-if="estadoChip=true">
                                   <v-chip v-if="index < 2" color="lgrey darken-3" dark label small>{{ text }}</v-chip>

                                   <span
                                           v-else-if="index === 2"
                                           class="overline grey--text text--darken-3 mx-2"
                                   >+{{ files.length - 2 }} File(s)</span>
                               </template>
                           </v-file-input>
                       </v-col>

                       <v-col>
                           <v-btn color="blue-grey" class="ma-2 white--text" @click="submitFiles" :disabled="disable">
                               Subir fotos
                               <v-icon right dark>mdi-cloud-upload</v-icon>
                           </v-btn>
                       </v-col>
                   </v-row>
               </div>
               <v-card-actions class="pb-4">
                   <v-btn
                           color="warning"
                           @click="limpiar">Cancelar</v-btn>
               </v-card-actions>           </v-card>
       </v-dialog>
        <div class="row">
            <div class="col">
                <v-btn
                        outlined
                        color="success"
                        dark
                        @click.stop="modal=true">
                    Agregar Fotos a album
                </v-btn>
            </div>
        </div>

        <div>
            <center>
                <v-select
                        style="width:600px"
                        label="seleccione album"
                        v-model="albums"
                        :items="albumes"
                        item-value="id"
                        item-text="nombre_album"
                        @change="validarSelectAlbum"
                />
            </center>
        </div>

        <center><div v-if="albums!==null">Nombre album: <b>{{nombre_album}}</b></div></center>
        <v-row>
            <v-col cols="12" sm="8" offset-sm="2"  v-if="albums!==null">
                <v-card>
                    <v-container fluid>
                        <v-row>
                            <v-col
                                    v-for="fotos in archivos"
                                    :key="fotos.id"
                                    class="d-flex child-flex"
                                    cols="12"
                            >
                                <v-card flat tile class="d-flex">
                                    <v-img
                                            :src="fotos.fotos"
                                            class="grey lighten-2"
                                    >
                                        <v-chip

                                                class="mr-2"
                                                color="red"
                                                @click="deleteItem(fotos)"
                                        >
                                            <v-icon left >mdi-delete</v-icon>
                                        Eliminar
                                        </v-chip>
                                        <template v-slot:placeholder>
                                            <v-row
                                                    class="fill-height ma-0"
                                                    align="center"
                                                    justify="center"
                                            >
                                                <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                            </v-row>
                                        </template>
                                    </v-img>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
    export default {
        data() {
            return {
                modal:false,
                disable:false,
                search:null,
                id:null,
                headers:[
                /*    {
                    text:'Album',
                    value:'album'
                },*/
                 {
                    text:'Foto',
                    value:'fotos'
                },
                    {
                        text:'Eliminar',
                        value:'eliminar'
                    }],
                archivos:[],
                alerta: false,
                files: null,
                nombre_album: null,
                album: null,
                albums: null,
                albumes: [],
            };
        },
        methods: {
            submitFiles() {
                this.disable=true
                /*
                    Initialize the form data
                  */
                let formData = new FormData();

                /*
                    Iteate over any file sent over appending the files
                    to the form data.
                  */
                for (var i = 0; i < this.files.length; i++) {
                    let file = this.files[i];

                    formData.append("files[" + i + "]", file);
                }
                formData.append('album',this.album)
                if (this.id !==null){
                    formData.append('id',this.id)
                }
                /*
                    Make the request to the POST /select-files URL
                  */
                let me=this;
                axios.post("/api/Galeria/subidaFicheros", formData, {
                        headers: {
                            "Content-Type": "multipart/form-data"
                        }
                    })
                    .then((response)=> {
                        this.$swal.fire(
                            '¡Exitoso!',
                            'Guardado',
                            'success'
                        )
                        me.getFiles()
                        me.limpiar()
                        this.disable=false
                    })

            },
            deleteItem(item){
                let me=this
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
                        axios.post('api/Galeria/deleteFicheros', {
                            id: item.id
                        }).then((response) => {
                            this.$swal.fire(
                                '¡Eliminado!',
                                '¡Categoría Eliminada',
                                'success'
                            )
                            this.validarSelectAlbum()
                            this.limpiar()
                        });
                    }
                });
            },
            validacion() {
                if (this.files != null && this.files !== "") {
                    this.submitFiles();
                } else {
                    this.alerta = true;
                }
            },
            getFiles(){
                let me=this;
                axios.post('/api/Galeria/getFiles',{
                    album:this.albums
                })
                    .then(function (response) {
                        me.archivos=response.data
                        if(response.data !==null && response.data !=='' && response.data!==[]){
                            let nombreAlbum = response.data
                            nombreAlbum.forEach(v =>{
                                me.nombre_album=v.album;
                            })
                        }

                    })
            },
            validarSelectAlbum(){
              if (this.albums!==null){
                  this.getFiles();
              }
            },
            getAlbum(){
                let me=this;
                axios.post('/api/Galeria/getAlbum')
                    .then(function (response) {
                        me.albumes=response.data
                    })
            },
            enviarDatosLi(){

            },

            limpiar(){
                this.album=null;
                this.files=null;
                this.id=null;
                this.modal=false;
                this.modal=false
            },

        },
        mounted(){
            this.getAlbum()
        }
    };
</script>

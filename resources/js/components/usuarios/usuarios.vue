<template>
<div class="container">
    <!--Abre ventana de formulario para agregar un nuevo usuario-->
    <v-dialog v-model="modal" width="500" persistent>
        <v-card class="align-center">
            <v-card-title class="">Registrar Usuario</v-card-title>
                <v-card >
                    <v-form
                        class="pt-5 pr-11 pl-11 pt-5">
                        <v-text-field
                            label="Codigo del Empleado"
                            v-model="codigoEmpleado"
                            required
                        ></v-text-field>

                        <v-text-field
                            label="Nombre"
                            v-model="nombre"
                            required
                        ></v-text-field>

                        <v-text-field
                            label="Correo"
                            v-model="email"
                            emailRules
                            required
                        ></v-text-field>

                        <v-text-field
                            label="Contraseña"
                            v-model="password"
                            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                            :rules="[rules.required, rules.min]"
                            :type="show1 ? 'text' : 'password'"
                            name="input-10-1"
                            hint="Ingrese 8 caracteres como minimo"
                            counter
                            @click:append="show1 = !show1"
                        ></v-text-field>

                        <v-text-field
                            label="Telefono"
                            v-model="telefono"
                            required
                        ></v-text-field>

                        <v-select
                            label="Area"
                            v-model="area"
                            :items="areasRecibidas"
                            item-text="descripcion"
                            item-value="id"
                            outlined
                            color="red"
                        />

                        <v-row>
                        <v-col cols="12" sm="6" md="4">
                          <v-menu
                            ref="menu"
                            v-model="menu"
                            :close-on-content-click="false"
                            :return-value.sync="date"
                            transition="scale-transition"
                            offset-y
                            min-width="290px"
                          >
                            <template v-slot:activator="{ on }">
                              <v-text-field
                                v-model="date"
                                label="Fecha de Nacimiento"
                                readonly
                                v-on="on"
                              ></v-text-field>
                            </template>
                            <v-date-picker v-model="date" no-title scrollable>
                              <v-spacer></v-spacer>
                              <v-btn text color="primary" @click="menu = false">Cancelar</v-btn>
                              <v-btn text color="primary" @click="$refs.menu.save(date)">Seleccionar</v-btn>
                            </v-date-picker>
                          </v-menu>
                        </v-col>
                        </v-row>

                        <v-select
                            label="Sexo"
                            v-model="sexo"
                            :items="sexos"
                            required
                            outlined
                            item-text="descripcion"
                            item-value="id"
                            color="red"
                        ></v-select>

                        <v-select
                            label="Estado"
                            v-model="estado"
                            :items="estados"
                            item-text="descripcion"
                            item-value="id"
                            color="red"
                            outlined
                        />

                      <!--  <v-select
                            label="Tipo Marcacion"
                            v-model="marcacion"
                            :items="marcacionTipos"
                            item-text="descripcion"
                            item-value="id"
                            color="red"
                            outlined
                        />-->


                        <v-file-input
                            v-if="id==null"
                            prepend-icon="mdi-camera"
                            v-model="files"
                            color="lgrey darken-3"
                            counter
                            label="Imagen de perfil"
                                            multiple
                                            outlined
                                            :show-size="1000"
                                    />
                        <div v-if="foto_perfil">
                            <v-img :src="foto_perfil" />
                        </div>

                        <v-card-actions class="pb-4">
                            <v-spacer></v-spacer>
                            <v-btn color="red darken-1" @click="limpiar">Cancelar</v-btn>
                            <v-btn color="green darken-1"  @click="validar">{{this.id == null?'Agregar':'Editar'}} Usuario</v-btn>
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
                        label="Buscar usuario"
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
                    Agregar usuario
                </v-btn>
            </div>

        </div>
        <!--tabla-->
        <v-card>
            <v-data-table
                :search="search"
                :headers="headers"
                :items="usuariosRecibidos"
                :items-per-page="5"
            >

            <template v-slot:item.editar="{item}">
                <v-btn text color="yellow darken-1"  @click="editarUsuario(item)">
                <v-icon>mdi-pencil</v-icon>
                </v-btn>
            </template>
            </v-data-table>
        </v-card>
      <!--  <div class="col text-right">
                <v-btn
                        outlined
                        color="warning"
                        dark
                        @click="est = true">
                    <v-icon>mdi-plus</v-icon>
                    Ver Usuarios {{this.est == false?'activos':'inactivos'}}
                </v-btn>
        </div>-->
</div>
</template>




<script>
    export default {
        data() {

            return {
                foto_perfil:null,
                files:null,
                show1: false,
                search:null,
                modal:false,
                est: false,
                id:null,
                nombre:null,
                email:null,
                telefono:null,
                area:null,
                sexo:null,
                estado:null,
                marcacion:null,
                codigoEmpleado:null,


                //para selecciona la fecha de cumpleaños
                date: new Date().toISOString().substr(0, 10),
                menu: false,

                //para la contraseña
                password: '',
                rules: {
                  required: value => !!value || 'Required.',
                  min: v => v.length >= 8 || 'Min 8 characters',

                },

                sexos: [],
                areasRecibidas: [],

                estados: [],
                marcacionTipos: [],

                //contenido que mostrara la tabla
                usuariosRecibidos:[],
                headers:[
                    {
                    text:'Codigo',
                    value:'codigoEmpleado'
                },
                    {
                    text:'Nombre',
                    value:'nombre'
                },
                    {
                    text:'Correo',
                    value:'correo'
                },
                    {
                    text:'Telefono',
                    value:'telefono'
                },
                    {
                    text:'Area',
                    value:'area'
                },
                    {
                    text:'Sexo',
                    value:'sexo'
                },
                    {
                    text:'Estado',
                    value:'estado'
                },

                    {
                    text:'Editar',
                    value:'editar'
                },

     ],
                //modalImg:false,
                //files: null,
                alerta:false,
                path:null
            };
        },
        methods: {
            recibirMarcacion(){
                axios.post('api/Estados/getMarcacion')
                    .then((response) => {
                        this.marcacionTipos = response.data
                    })
            },
            validar(){
                if (this.nombre!==null && this.nombre!=='' && this.email!==null && this.email!==''
                && this.telefono!==null && this.telefono!=='' && this.area !==null && this.area!==''
                && this.codigoEmpleado!==null && this.password!==null && this.password!=='' && this.estado!==null
                && this.estado!=='' && this.sexo!==null && this.sexo!=='') {
                    this.agregarUsuario()
                }else{
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Llene todos los campos!'
                    })
                }
            },
            agregarUsuario() {
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
                if (this.id !==null){
                    formData.append('id',this.id)
                }
                formData.append('nombre',this.nombre)
                formData.append('correo',this.email)
                formData.append('password',this.password)
                formData.append('telefono',this.telefono)
                formData.append('Area',this.area)
                formData.append('fechaDeNacimiento',this.fechaDeNacimiento)
                formData.append('sexo',this.sexo)
                formData.append('estado',this.estado)
                formData.append('codigoEmpleado',this.codigoEmpleado)
                formData.append('marcacion',this.marcacion)
                axios.post("api/Usuarios/postusuarios",formData, {
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
                        this.modal=false
                        this.limpiar()
                        this.obtenerUsuarios()
                        //this.getFiles()
                    })


            },

            obtenerUsuarios(){
                axios.post('api/Usuarios/getusuarios')
                    .then((response) => {
                        this.usuariosRecibidos = response.data.data
                        this.areasRecibidas = response.data.data2
                        this.sexos = response.data.data3
                        this.estados = response.data.data4
                    })
            },
            obtenerEstadoUsuariosCero(){
                axios.post('api/Usuarios/getusuariosestadocero')
                    .then((response) => {
                        this.usuariosRecibidos = response.data
                    })
            },

             limpiar(){
                this.modal=false;
                this.nombre=null;
                this.email=null;
                this.password=null;
                this.telefono=null;
                this.area=null;
                this.date=null;
                this.sexo=null;
                this.estado=null;
                this.codigoEmpleado=null;
                this.id=null;
                this.files=null;
                this.foto_perfil=null;
                this.marcacion=null;
            },
            editarUsuario(item){
                this.modal=true
                this.id=item.id;
                this.nombre=item.nombre;
                this.email=item.correo;
                this.password=item.password;
                this.telefono=item.telefono;
                this.area=item.aid;
                this.date=item.fechaDeNacimiento;
                this.sexo=item.sid;
                this.estado=item.eid;
                this.codigoEmpleado=item.codigoEmpleado;
                this.foto_perfil=item.foto_perfil;
                this.marcacion=item.marcacion;

            },
            recibirCargo(){
                axios.post('api/Usuarios/getCargo')
                    .then((response) => {
                        this.cargos = response.data
                    })
            },
            mostrarUsuarios(){
                if (est == false) {
                    this.obtenerUsuarios()
                }
                else{
                   this.obtenerEstadoUsuariosCero()
                }

            },



        },
        mounted(){
            //this.getFiles()
            this.obtenerUsuarios()
            this.recibirMarcacion()
        }
    };
</script>

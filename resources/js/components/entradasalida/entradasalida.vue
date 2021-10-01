<template>
<div class="container">
        <div class="row pb-4 ">
            <div class="col-3">
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Buscar registro"
                    single-line
                    hide-details
                ></v-text-field>
            </div>
        </div>
    <v-row>
        <v-col cols="4">
            <v-menu
            ref="menu"
            v-model="menu"
            :close-on-content-click="false"
            :return-value.sync="date"
            transition="scale-transition"
            offset-y
            min-width="290px"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-text-field
                    v-model="date"
                    label="Dia"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                ></v-text-field>
            </template>
            <v-date-picker v-model="date" no-title scrollable @change="obtenerRegistros">
                <v-spacer></v-spacer>
                <v-btn text color="primary" @click="menu = false">Cancel</v-btn>
                <v-btn text color="primary" @click="$refs.menu.save(date)">OK</v-btn>
            </v-date-picker>
        </v-menu>
        </v-col>
      <!--  <v-col cols="4">
            <v-menu
                ref="menu2"
                v-model="menu2"
                :close-on-content-click="false"
                :return-value.sync="date2"
                transition="scale-transition"
                offset-y
                min-width="290px"
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                        v-model="date2"
                        label="Hasta"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                    ></v-text-field>
                </template>
                <v-date-picker v-model="date2" no-title scrollable>
                    <v-spacer></v-spacer>
                    <v-btn text color="primary" @click="menu2 = false">Cancel</v-btn>
                    <v-btn text color="primary" @click="$refs.menu2.save(date2)">OK</v-btn>
                </v-date-picker>
            </v-menu>
        </v-col>

        <v-col cols="4">
            <v-btn outlined>Generar</v-btn>
        </v-col>-->
    </v-row>


   <!-- <v-dialog v-model="modal" width="500px">
        <v-card>
            <v-card-title><center>Horas trabajadas</center></v-card-title>
            <v-card>
                <center>
                    <div>Nombre: {{nombre}}</div>
                    <div>Horas: {{horas}}</div>
                </center>
            </v-card>
        </v-card>
    </v-dialog>-->
        <!--tabla-->
    <!--<v-row>
        <v-col>
            <div class="my-2">
                <v-btn color="red" fab x-small dark>
                    <v-icon></v-icon>
                </v-btn>  Entrada tarde
            </div>
        </v-col>
        <v-col>
            <div class="my-2">
                <v-btn color="green" fab x-small dark>
                    <v-icon></v-icon>
                </v-btn>  Entrada normal
            </div>
        </v-col>
    </v-row>-->
        <v-card>
            <v-data-table
                :search="search"
                :headers="headers"
                :items="registrosRecibidos"
                :items-per-page="5"
            >
                <template v-slot:item.entrada="{ item }">
                    <v-chip :color="getColor(item)">{{ item.entrada }}</v-chip>
                </template>
              <!--  <template v-slot:item.horas_trabajadas="{ item }">
                        <v-btn style="font-size:10px;color:white" color="#D11E48" @click="verHrs(item)">Ver horas trabajadas</v-btn>
                </template>-->
            </v-data-table>
        </v-card>
</div>
</template>

<script>
    export default {
        data() {

            return {
                date: new Date().toISOString().substr(0, 10),
                date2: new Date().toISOString().substr(0, 10),
                menu: false,
                modal: false,
                modal2: false,
                menu2: false,

                alert:false,
                search:null,
                modalentrada:false,
                modalsalida:false,
                modal:false,

                //inicialisando los valores
                id:null,
                tipo:null,
                detalle:null,
                nombre:null,
                horas:null,

                //contenido que mostrara la tabla
                registrosRecibidos:[],
                headers:[
                    {
                    text:'Usuario',
                    value:'name'
                },
                    {
                    text:'Entrada',
                    value:'entrada'
                },
                    {
                    text:'Salida',
                    value:'salida'
                },
               /* {
                    text:'Ver Hrs Trabajadas',
                    value:'horas_trabajadas'
                }*/
                ],
            };
        },

        methods: {

            getColor (item) {
                if (item.horas_entrada>8) return 'white'
                else return 'white'
            },

            verHrs(item) {
                this.modal=true;
                this.nombre=item.name
                this.horas=item.horas_trabajadas
            },

            obtenerRegistros(){
                axios.post('api/EntradaSalida/getregistro',{
                    fecha:this.date
                })
                    .then((response) => {
                        this.registrosRecibidos = response.data
                    })
            },

        },


        mounted(){
            this.obtenerRegistros()
        }

};
</script>

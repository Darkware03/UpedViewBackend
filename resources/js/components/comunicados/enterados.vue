<template>
<div>
    <div class="col-4">
        <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Buscar"
            single-line
            hide-details
        ></v-text-field>
    </div>
    <v-card class="">
        <v-data-table
            :headers="headers"
            :items="data"
            :items-per-page="5"
            :search="search"
            class="elevation-1"
        >
            <template v-slot:item.enterado="{item}">
                    <v-icon color="green darken-1">mdi-check</v-icon>
            </template>
        </v-data-table>
    </v-card>
</div>
</template>

<script>
    export default {
        data () {
            return {
                data: [],
                search: '',
                headers:[
                    {
                        text:'Usuario',
                        value:'name'
                    },
                    {
                        text:'Comunicado',
                        value:'titulo',
                    },
                    {
                        text:'Enterado',
                        value:'enterado',
                    },
                ],
            }
        },
        methods:{
            recibirData(){
                axios.post('api/Comunicados/enteradousuarios')
                    .then((response) => {
                        this.data = response.data
                    })
            },
        },
        mounted() {
            this.recibirData()
        }
    }
</script>

<style scoped>

</style>

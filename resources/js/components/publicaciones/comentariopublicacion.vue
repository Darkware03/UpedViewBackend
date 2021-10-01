<template>
    <v-card>
        <v-card-title>
            Comentario en publicaciones
            <v-spacer></v-spacer>
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Busca por palabra, usuario o publicacion"
                single-line
                hide-details
            ></v-text-field>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="desserts"
            :search="search"
        ></v-data-table>
    </v-card>
</template>
<script>
export default {
    data () {
        return {
            search: '',
            headers: [
                { text: 'PUBLICACION',value: 'titulo' },
                { text: 'USUARIO', value: 'name' },
                { text: 'COMENTARIO', value: 'comentario' },
            ],
            desserts: [],
        }
    },
    methods: {
        getFiles(){
            let me = this
            axios.post('api/Publicaciones/getcomentariospublicacion')
                .then(function (response) {
                    me.desserts=response.data
                    console.log(this.desserts)
                })
        },
    },
    mounted() {
        this.getFiles()
    }
}
</script>

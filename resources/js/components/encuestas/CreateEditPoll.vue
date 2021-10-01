<template>
    <v-container>
        <v-stepper v-model="step">
            <v-stepper-header v-if="$route.name == 'create-poll'">
                <v-stepper-step :complete="step > 1" step="1">Paso 1: Crear Encuesta</v-stepper-step>

                <v-divider></v-divider>

                <v-stepper-step :complete="step > 2" step="2">Paso 2: Agregar Opciones</v-stepper-step>
            </v-stepper-header>

            <v-stepper-items>
                <v-stepper-content step="1">
                    <v-text-field
                        label="¿Cuál es el título de su encuesta?"
                        v-model="title"
                        single-line
                        full-width
                        hide-details
                        required
                    ></v-text-field>
                    <v-divider></v-divider>
                    
                    <v-divider></v-divider>
                    <v-textarea
                        v-model="description"
                        label="Agregue una descripción"
                        counter
                        maxlength="120"
                        full-width
                        single-line
                    ></v-textarea>
                    <template v-if="$route.name == 'edit-poll'">
                        <v-btn
                            color="primary"
                            @click="updatePoll"
                            :loading="isLoading"
                            >
                            Actualizar
                        </v-btn>
                    </template>
                    <template v-else>
                        <v-btn
                            color="primary"
                            @click="createNewPoll"
                            :loading="isLoading"
                            :disabled="this.title == '' ? true : false"
                            >
                            Continuar
                        </v-btn> 
                    </template>
                            
                </v-stepper-content>

                <v-stepper-content step="2">
                    <template v-for="(option, index) in options">
                        <v-text-field
                            :key="index"
                            label="Agregue una opción:"
                            v-model="option.option"
                            single-line
                            full-width
                            hide-details
                            clearable
                            @click:append-outer="deleteOption(index)"
                        ></v-text-field>
                    </template>   
                    <v-btn
                        color="primary"
                        @click="saveOptions"
                        :loading="isLoading"
                        :disabled="this.options[0].option == '' ? true : false"
                        >
                        Finalizar
                    </v-btn>
                </v-stepper-content>
            </v-stepper-items>
        </v-stepper>
    </v-container>
  
</template>
<script>
  export default {
    data () {
      return {
        step: 1,
        isLoading: false,
        options: [
            {
                option: ''
            }
        ]
      }
    },
    computed: {
        modeLabel() {
            return 'Tipo: '+ this.$store.getters.poll.type
        },
        title: {
            get() {
                return this.$store.getters.poll.title
            },
            set(val) {
                this.$store.commit('POLL_TITLE', val)
            }
        },
        description: {
            get() {
                return this.$store.getters.poll.description
            },
            set(val) {
                this.$store.commit('POLL_DESCRIPTION', val)
            }
        },
        mode: {
            get() {
                return this.$store.getters.poll.type == 'multi' ? true : false
            },
            set(val) {
                let mode = 'Predeterminado'
                if(val === true)
                    mode = 'Predeterminado'
                this.$store.commit('POLL_MODE', mode)
            }
        }
    },
    watch: {
        options: {
            handler(val, oldVal) {
                this.watchOptionCount()
            },
            deep: true       
        }
    },
    methods: {
        async createNewPoll() {
            this.isLoading = true
            let res = await this.$store.dispatch('createNewPoll')
            if(res == 'created'){
                this.isLoading = false
                this.step = 2
            }else
                this.isLoading = false
        },
         async updatePoll() {
            this.isLoading = true
            let res = await this.$store.dispatch('updatePoll')
            if(res == 'updated'){
                this.isLoading = false
                this.$router.push(`/poll/${this.$route.params.id}`)
            }else
                this.isLoading = false
        },
        async saveOptions() {
            this.isLoading = true
            let res = await this.$store.dispatch('saveOptions', this.options)
            if(res == 'created'){
                this.isLoading = false
                this.$router.push('/encuestas')
            }else
                this.isLoading = false
        },
        watchOptionCount() {
            const optionsCount = this.options.length
            if(this.options[optionsCount-1].option !== '')
                this.options.push({
                    option: ''
                })
        },
        deleteOption(index) {
            if(this.options.length == 1) {
                this.options.push({
                    option: ''
                })
            }
            this.options.splice(index, 1);
        },
        fetchPoll() {
            this.$store.dispatch('poll', this.$route.params.id)
        },
    },
    mounted() {
        if(this.$route.name == 'create-poll')
            this.$store.commit('POLL', 'reset')
        if(this.$route.name == 'edit-poll')
            this.fetchPoll()

    }
  }
</script>
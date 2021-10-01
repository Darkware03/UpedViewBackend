<template>
    <v-container>
        <v-layout>
            <v-flex md8 pr-2>
                <v-card>
                    <v-card-title primary-title>
                        <div  class="text-xs-left">
                            <div class="headline">{{ poll.title }}</div>
                            
                            <span>{{ poll.description }}</span>
                        </div>
                    </v-card-title>
                    <v-card-actions>
                        <v-container fluid>
                            <template v-if="poll.type === 'single'">
                                <v-radio-group v-model="votes" column>
                                    <template v-for="option in poll.options">
                                        <v-radio :key="option.id" :label="option.option" :value="option.id"></v-radio>
                                    </template>
                                </v-radio-group>
                            </template>
                            <template v-else>
                                <template v-for="option in poll.options">
                                    <v-checkbox v-model="votes" :key="option.id" :label="option.option" :value="option.id"></v-checkbox>
                                </template>
                            </template>
                            <v-list v-if="viewOptionRequests">
                                <v-subheader>Sugerir Opciones</v-subheader>
                                <v-list-tile
                                    v-for="option in poll.option_requests"
                                    :key="option.id"
                                    @click="true"
                                >
                                    <v-list-tile-content>
                                        <v-list-tile-title v-html="option.option"></v-list-tile-title>
                                    </v-list-tile-content>

                                    <v-list-tile-action>
                                        <v-icon text :color="option.status == 'requested' ? 'teal' : 'grey'" @click="approveOption(option)">done</v-icon>
                                    </v-list-tile-action>
                                </v-list-tile>
                            </v-list>
                            <v-btn
                                color="primary"
                                @click="submitPoll"
                                :loading="isLoading"
                                :disabled="this.myVotesCount == true"
                                >
                                {{ myVotesCount > 0 ? 'Usted ya votó' : 'Votar'}}
                            </v-btn> 
                            <template v-if="poll.isMyPoll">
                                <v-btn color="orange" :to="`/poll/${poll.id}/edit`">Editar</v-btn>
                                <v-btn color="red" @click="deleteConfirm = true">Eliminar</v-btn>
                            </template>
                            <template  v-else>
                                <OptionRequest/>
                            </template>
                        </v-container>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex md4 pl-2>
                <v-card>
                    <v-card-title primary-title>
                        <template v-if="chartData">
                            <pie-chart :data="chartData"></pie-chart>
                        </template>
                         
                        <template v-if="!myVotesCount &&  !poll.isMyPoll">
                            <p>
                                Vote para ver los resultados
                            </p>
                        </template>
                        <template v-if="poll.isMyPoll && !chartData">
                            <p>
                                Sin votos aún...
                            </p>
                        </template>
                    </v-card-title>
                    <v-card-actions>
                        <p v-if="myVotesCount" class="font-weight-medium">
                            Votos: 
                            <span class="font-weight-black">{{ myVotesCount }}</span>
                        </p>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
        
        <v-dialog
            v-model="deleteConfirm"
            max-width="400"
            >
            <v-card>
                <v-card-title class="headline">¿Está seguro de eliminar la encuesta?</v-card-title>
                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="green darken-1"
                        @click="deleteConfirm = false"
                    >
                        Cancelar
                    </v-btn>

                    <v-btn
                        color="red darken-1"
                        @click="deletePoll"
                    >
                        Sí, borrar
                    </v-btn>
                </v-card-actions>
            </v-card>
            </v-dialog>
    </v-container>
</template>

<script>
import OptionRequest from './OptionRequest'

export default {
    components: {
        OptionRequest
    },
    data() {
        return {
            deleteConfirm: false,
            message: '',
            snackbar: false,
            votes: [],
            isLoading: false
        }
    },
    computed: {
        viewOptionRequests() {
            if(typeof this.poll.option_requests !== 'undefined' && this.poll.option_requests.length > 0 && this.poll.isMyPoll)
                return true
            return false
        },
        poll() {
            return this.$store.getters.poll
        },
        chartData() {
            let poll = this.$store.getters.poll
            let options = poll.options
            let voteCount = poll.votes_count
            if(voteCount < 1 || !options)
                return false

            if(!poll.isMyPoll)
                if(!poll.my_votes_count)
                    return false
            let chart = []
            options.map(option => {
                chart.push([
                    option.option,
                    option.vote_count
                ])
            })
            return chart
        },
        myVotesCount() {
            return this.$store.getters.poll.my_votes_count
        }
    },
    methods:{
        fetchPoll() {
            this.$store.dispatch('poll', this.$route.params.id)
        },
        async submitPoll() {
            
            let res = await this.$store.dispatch('submitPoll', this.votes)
            
        },
        async deletePoll() {
            let res = await this.$store.dispatch('deletePoll', this.$route.params.id)
            if(res == 'deleted')
                this.$router.push({'path': '/encuestas'})
        },
        async approveOption(option) {
            let res = await this.$store.dispatch('approveOption', option.id)
        }
    },
    mounted() {
        this.fetchPoll()
    }   
}
</script>

<style>

</style>

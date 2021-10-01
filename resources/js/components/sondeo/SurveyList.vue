<template>
    <div class="flex w-full h-full m-4">
        <div class="font-normal text-3xl text-gray-700 m-auto"
            :class="[{ 'hidden' : surveyList.length > 0 },
                    { 'visible' : surveyList.length < 1 }]">
            <span>Aún no creas ningún sondeo...<span class="font-bold">¡Cree uno ahora mismo! </span></span>
        </div>

        <div class="flex-row w-full h-full"
            :class="[{ 'visible' : surveyList.length > 0 },
                    { 'hidden' : surveyList.length < 1 }]">
            <div v-for="(survey, index) in surveyList" v-bind:key="index"
                class="w-full max-w-md m-auto flex-row h-auto pb-4">
                <div class="w-full rounded-sm bg-gray-300 flex p-2">
                    <div class="w-1/2 flex-row">
                        <div class="font-bold text-xl text-black flex">
                            <span>
                                {{ survey.title }}
                            </span>
                        </div>
                        <div class="font-normal text-2xl text-black flex mb-2">
                            <span>
                                {{ survey.description }}
                            </span>
                        </div>
                        <div class="font-normal text-sm text-black flex">
                            <span>
                                Activo desde: {{ $moment(survey.duration.split("|")[0]).format('LL')  }}
                            </span>
                        </div>
                        <div class="font-normal text-sm text-black flex">
                            <span>
                                Hasta el: {{ $moment(survey.duration.split("|")[1]).format('LL') }}
                            </span>
                        </div>
                    </div>
                    <div class="w-1/2 flex-row">
                        <a :href="'/home#/detalles/sondeo/' + survey.slug">
                            <button type="button" class="btn btn-primary btn-block">Detalles</button>
                        </a>
                        <br>
                        <a :href="'/home#/sondeo/' + survey.slug">
                            <button type="button" class="btn btn-success btn-block">Responder</button>
                        </a>
                        <button type="button" class="btn btn-danger btn-block mt-2"
                            v-on:click="deleteSurvey(survey, index)">Borrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'token',
        ],

        data() {
            return {
                surveyList: [],
            }
        },

        mounted() {

            const globe = this;

            globe
                .$axios.get('/api/getSurveyList', {
                    headers: {
                        'Authorization': `Bearer ${globe.token}`
                    }
                }).then(response => {

                    if(response.data.message === "success") {
                        globe.surveyList = response.data.surveyList;
                    } else {
                        globe.$toasted.global.showError({
                            message: response.data.message
                        });
                    }
                });
        },

        methods: {
            deleteSurvey: function($survey, $index) {

                const globe = this;

                if (confirm("¿Está seguro que quiere borrar este sondeo?")) {

                    globe
                        .$axios.post('/api/deleteSurvey', $survey, {
                            headers: {
                                'Authorization': `Bearer ${globe.token}`
                            }
                        }).then(response => {

                            if(response.data.message === "success") {

                                globe.surveyList.splice($index, 1);
                                
                                 this.$swal.fire(
                                        '¡Eliminado!',
                                        'Link Eliminado',
                                        'success'
                                    )

                            } else {
                                globe.$toasted.global.showError({
                                    message: response.data.message
                                });
                            }
                        });
                }
            }
        }
    }
</script>

<template>
    <div class="w-full h-full flex">
        <form class="w-full max-w-md m-auto">
            <div class="flex items-center mb-6">
                <div class="w-1/3">
                    <label class="block text-gray-600 font-bold text-right mb-1 mb-0 pr-4 text-lg">
                        Título de la encuesta:
                    </label>
                </div>
                <div class="w-2/3">
                    <input v-model="surveyForm.title" 
                        class="bg-gray-200 appearance-none text-xl border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500" 
                        type="text" placeholder="">
                </div>
            </div>

            <div class="flex items-center mb-6">
                <div class="w-1/3">
                    <label class="block text-gray-600 font-bold text-right mb-1 mb-0 pr-4 text-lg">
                        Descripción:
                    </label>
                </div>
                <div class="w-2/3">
                    <textarea v-model="surveyForm.description" cols="30" rows="3"
                        class="resize-none text-xl bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500" 
                        type="text" placeholder=""/>
                </div>
            </div>

            <div class="flex items-center mb-6">
                <div class="w-1/3">
                    <label class="block text-gray-600 font-bold text-right mb-1 mb-0 pr-4 text-lg">
                        Duración de la encuesta:
                    </label>
                </div>
                <div class="w-2/3">
                    <vc-date-picker
                        v-model='surveyForm.duration' mode="range" :min-date='new Date()' color="red" is-dark/>
                </div>
            </div>

            <form v-for="(content, index) in contents" v-bind:key="index" 
                class="w-full flex-row h-auto mb-4">
                <div class="w-full flex-row rounded-sm bg-gray-400 m-2">

                    <button type="button" class="btn btn-danger btn-block mb-2" v-on:click="
                        contents.splice(index, 1);
                    ">Borrar este contenido</button>

                    <div class="w-10/12 h-8 flex rounded-sm mb-2 mx-auto appearance-none cursor-pointer select-none"
                        :class="[{ 'bg-green-500' : contents[index].isRequired },
                                { 'bg-gray-500' : !contents[index].isRequired }]" 
                        v-on:click="contents[index].isRequired = !contents[index].isRequired">
                        <span class="w-auto m-auto"
                            :class="[{ 'visible' : contents[index].isRequired },
                                    { 'hidden' : !contents[index].isRequired }]">
                            Respuesta obligatoria
                        </span>
                        <span class="w-auto m-auto"
                            :class="[{ 'hidden' : contents[index].isRequired },
                                    { 'visible' : !contents[index].isRequired }]">
                            Respuesta opcional
                        </span>
                    </div>

                    <div class="flex items-center p-2">
                        <div class="w-1/3">
                            <label class="block text-gray-600 font-bold text-right mb-1 mb-0 pr-4">
                                Tipo
                            </label>
                        </div>
                        <div class="w-2/3">
                            <select v-model="contents[index].type" 
                                class="block resize-y resize-none text-lg bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500">
                                <option value="" disabled selected class="text-gray-400">Elija el tipo de respuesta</option>
                                <option value="0">Texto</option>
                                <option value="1">Fecha</option>
                                <option value="2">Radio (Una respuesta)</option>
                                <option value="3">Checkbox (Múltiple respuesta)</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center p-2">
                        <div class="w-1/3">
                            <label class="block text-gray-600 font-bold text-right mb-1 mb-0 pr-4">
                                Pregunta
                            </label>
                        </div>
                        <div class="w-2/3">
                            <textarea v-model="contents[index].question" cols="30" rows="3"
                                class="resize-y resize-none text-lg bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500" 
                                type="text" placeholder=""/>
                        </div>
                    </div>

                    <div class="flex-row w-full"
                        :class="[{ 'visible': contents[index].type == '2' || 
                                            contents[index].type == '3' },
                                { 'hidden': contents[index].type != '2' && 
                                            contents[index].type != '3' }]">
                        <div class="w-full flex">
                            <div class="w-full h-1 bg-gray-700 my-auto mx-4"/>
                            <span class="w-auto ml-auto pr-4 font-bold text-xl text-gray-700">Opciones</span>
                        </div>
                        <div v-for="(option, optionIndex) in contents[index].choices" v-bind:key="optionIndex" 
                            class="w-full flex h-auto">
                            <div class="flex items-center p-2">
                                <div class="w-1/3 flex-row">
                                    <label class="block text-gray-600 font-bold text-right mb-1 mb-0 pr-4">
                                        Opción No. {{ optionIndex+1 }}
                                    </label>

                                    <div class="w-16 flex ml-auto">
                                        <button type="button" class="btn btn-secondary btn-sm mr-2 mb-2 w-16" 
                                            v-on:click="contents[index].choices.splice(optionIndex, 1)">
                                            Borrar
                                        </button>
                                    </div>
                                </div>
                                <div class="w-2/3">
                                    <textarea v-model="contents[index].choices[optionIndex]" cols="30" rows="3"
                                        class="resize-y resize-none text-lg bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full h-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500" 
                                        type="text" placeholder=""/>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary ml-2 mb-2" v-on:click="
                            contents[index].choices.push('')
                        ">Agregar nueva opción</button>
                    </div>
                </div>
            </form>

            <button type="button" class="btn btn-primary btn-block m-2" v-on:click="
                contents.push({
                    id: 0,
                    type: '',
                    question: '',
                    right_answer: '',
                    choices: [
                        'This is example answer',
                    ],
                    isRequired: false,
                })">
                Agregar otra pregunta
            </button>

            <button type="button" class="btn btn-primary btn-block m-2" v-on:click="saveSurvey()">Guardar</button>
            
            <a :href="'home#/sondeos/' + surveyForm.slug">
                <button type="button" class="btn btn-danger btn-block m-2">Cancelar Edición</button>
            </a>
        </form>
    </div>
</template>

<script>
    export default {
        props: [
            'token',
        ],

        data() {
            return {
                surveyForm: {},
                contents: [],  
            };
        },

        mounted() {
        
            const globe = this;

            globe
                .$axios.get('/api/getSurvey/'+(window.location.href.substring(window.location.href.lastIndexOf('/') + 1)), {
                    headers: {
                        'Authorization': `Bearer ${globe.token}`
                    } 
                }).then(response => {

                    if(response.data.message === "success") {

                        globe.surveyForm = response.data.survey;
                        globe.contents = response.data.contents;

                        let startDate = new Date(globe.surveyForm.duration.split('|')[0])
                        let endDate = new Date(globe.surveyForm.duration.split('|')[1])
                        globe.surveyForm.duration = {
                            start: startDate,
                            end: endDate
                        }

                        for (let index = 0; index < globe.contents.length; index++) {
                        
                            globe.contents[index].choices = globe.contents[index].choices.split('|');
                            globe.contents[index].type = globe.contents[index].type.toString();
                        }

                    } else {
                        globe.$toasted.global.showError({
                            message: response.data.message
                        });
                    }
                });
        },

        methods: {
            saveSurvey: function() {
                const globe = this;

                if(globe.surveyForm.title == '') {
                    globe.$toasted.global.showError({
                        message: "El título no debe ir vacío"
                    });
                    return;
                }

                if(globe.surveyForm.description == '') {
                    globe.$toasted.global.showError({
                        message: "La descripción no debe ir vacía"
                    });
                    return;
                }

                if(globe.surveyForm.duration == '') {
                    globe.$toasted.global.showError({
                        message: "La duración no debe ir vacía"
                    });
                    return;
                }

                if(globe.contents.length < 1) {
                    globe.$toasted.global.showError({
                        message: "Debe haber al menos 1 contenido"
                    });
                    return;
                }

                for(let i=0; i<globe.contents.length; i++) {
                    if(globe.contents[i].type == '') {
                        globe.$toasted.global.showError({
                            message: "Escoja el tipo de pregunta"
                        });
                        return;
                    }

                    if(globe.contents[i].question == '') {
                        globe.$toasted.global.showError({
                            message: "Las preguntas no deben ir vacías"
                        });
                        return;
                    }

                    if(globe.contents[i].choices.length < 1) {
                        globe.$toasted.global.showError({
                            message: "Debe haber al menos una opción"
                        });
                        return;
                    }
                }

                globe
                    .$axios.post('/api/addContents', globe.contents, {
                        headers: {
                            'Authorization': `Bearer ${globe.token}`
                        }
                    }).then(response => {

                        if(response.data.message === "success") {

                            globe.surveyForm.content_ids = response.data.contentIds;
                            globe
                                .$axios.post('/api/addSurvey', globe.surveyForm, {
                                    headers: {
                                        'Authorization': `Bearer ${globe.token}`
                                    }
                                }).then(response => {

                                    if(response.data.message === "success") {
                                        globe.$toasted.global.showSuccess({
                                            message: "Editado Satisfactoriamente"
                                        });
                                        window.location.replace("/home#/sondeos");
                                    } else {
                                        globe.$toasted.global.showError({
                                            message: response.data.message
                                        });
                                    }
                                });

                        } else {
                            globe.$toasted.global.showError({
                                message: response.data.message
                            });
                        }
                    });
            },
        }
    }
</script>
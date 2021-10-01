require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
import Vuetify from 'vuetify'
import VueSweetalert2 from 'vue-sweetalert2';
import VueChartkick from 'vue-chartkick'
import Chart from 'chart.js'
import store from './store'
import Toasted from 'vue-toasted';
import VCalendar from 'v-calendar';
import Moment from 'moment';
import Axios from 'axios';
import VueQrcode from '@chenfengyuan/vue-qrcode';
import JsonExcel from 'vue-json-excel';

window.Vue = require('vue');

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(Toasted);
Vue.prototype.$moment = Moment;
Vue.prototype.$axios = Axios;

Vue.toasted.register('showError',
    (payload) => {
        if(! payload.message) {
    	    return "Sorry error happened, please try again"
        }
        return payload.message;
    },
    {
      type: "error",
      position: "bottom-center",
      duration : 2000
    }
)

Vue.toasted.register('showSuccess',
    (payload) => {
        if(! payload.message) {
    	    return "Request successfully processed"
        }
        return payload.message;
    },
    {
      type: "success",
      position: "bottom-center",
      duration : 2000
    }
)

Vue.use(VCalendar, {
    componentPrefix: 'vc',  // Use <vc-calendar /> instead of <v-calendar />
});

Vue.component(VueQrcode.name, VueQrcode);
Vue.component('downloadExcel', JsonExcel)

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.use(VueSweetalert2);
Vue.use(Vuetify);
Vue.use(VueRouter);
Vue.use(VueChartkick, {adapter: Chart})
import VueSidebarMenu from 'vue-sidebar-menu'
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'
Vue.use(VueSidebarMenu)
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('sidebar-component', require('./components/assetsSidebar/sidebar.vue').default);
/**
aqui en router aggg las rutas
 */
const  routes =[
    //aqui agregan las rutas en vez de registrar un componente por ejemplo
    //{path:'como quiero acceder', commponent:require('ruta del componente').default},
    //ahora vamos al app.blade.php
    {path: '/publicaciones', component: require('./components/publicaciones/publicaciones.vue').default},
    {path: '/comunicados', component: require('./components/comunicados/comunicados.vue').default},
    {path: '/enterados', component: require('./components/comunicados/enterados.vue').default},
    {path: '/Linksinteres', component: require('./components/Linksinteres/Interes.vue').default},
    {path: '/areas', component: require('./components/areas/areas.vue').default},
    {path: '/categoriapublicacion', component: require('./components/categoriapublicacion/categoriapublicacion.vue').default},
    {path: '/estados', component: require('./components/estados/estados.vue').default},
    {path: '/Usuarios', component: require('./components/usuarios/usuarios.vue').default},
    {path: '/categorianoticia', component: require('./components/categorianoticia/categorianoticia.vue').default},
    {path: '/noticias', component: require('./components/noticias/noticias.vue').default},
    {path: '/eventos', component: require('./components/eventos/eventos.vue').default},
    {path: '/galeria_fotos', component: require('./components/subir_imagenes/galeria_fotos.vue').default},
    {path: '/album', component: require('./components/subir_imagenes/album.vue').default},
    {path: '/asuntos', component: require('./components/asuntos/asuntos.vue').default},
    {path: '/correopersonales', component: require('./components/correopersonales/correopersonales.vue').default},
    {path: '/sugerencias', component: require('./components/sugerencias/sugerencias.vue').default},
    {path: '/encuestas', name: 'polls', component: require('./components/encuestas/Lists.vue').default},
    {path: '/nuevaencuesta', name:'create-poll', component: require('./components/encuestas/CreateEditPoll.vue').default},
    {path: '/poll/:id/edit', name:'edit-poll', component: require('./components/encuestas/CreateEditPoll.vue').default},
    {path: '/poll/:id', name:'poll', component: require('./components/encuestas/SingleView.vue').default},
    {path: '/solicitudesvacaciones', component: require('./components/solicitudesvacaciones/solicitudesvacaciones.vue').default},
    {path: '/entradasalida', component: require('./components/entradasalida/entradasalida.vue').default},
    {path: '/nuevo_sondeo', component: require('./components/sondeo/Survey.vue').default},
    {path: '/sondeos', component: require('./components/sondeo/SurveyList.vue').default},
    {path: '/sondeo/:path', component: require('./components/sondeo/SurveyView.vue').default},
    {path: '/detalles/sondeo/:path', component: require('./components/sondeo/SurveyDetail.vue').default},
    {path: '/editar_sondeo/:path', component: require('./components/sondeo/SurveyEdit.vue').default},
    {path: '/Cargos', component: require('./components/usuarios/cargo.vue').default},
    {path: '/', component: require('./components/inicio.vue').default},
    {path: '/comentariopublicacion', component: require('./components/publicaciones/comentariopublicacion.vue').default},
]
const router = new VueRouter({
    routes:routes
})
const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    router,
    store,
    created() {
        this.$store.dispatch('loggedUser')
    }
});

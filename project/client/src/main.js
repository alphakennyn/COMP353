import Vue from 'vue'
import App from './App.vue'
import router from './router'
import VueResource from 'vue-resource';
import VModal from 'vue-js-modal';
import ToggleButton from 'vue-js-toggle-button';
import VueSession from 'vue-session';

Vue.config.productionTip = false
Vue.use(VueSession)
Vue.use(VueResource);
Vue.use(VModal)
Vue.use(ToggleButton)

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')

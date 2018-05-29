require('./bootstrap');

import router from './router';
import store from './vuex/store';

new Vue({
	store,
    router
}).$mount('#app')
require('./bootstrap');

import VueRouter from 'vue-router'

Vue.use(VueRouter)

// 匯入 Hello.vue 檔，不需加副檔名
import Hello from './components/Hello'
import Count from './components/Count'

const routes = [
	{
        path: '/vue/hello',
        name: 'hello',
        component: Hello
    },
    {
        path: '/vue/count',
        name: 'count',
        component: Count,
    },
];

const router = new VueRouter({
    mode: 'history',
    routes: routes,
});

new Vue({
    // 使用我們建立的 Hello(.vue) 元件
    // components: { 
    // 	Hello
    // },
    router
}).$mount('#app')
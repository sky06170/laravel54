import VueRouter from 'vue-router'

Vue.use(VueRouter)

//Router Path
const routes = [
	{
        path: '/vue/hello',
        name: 'vue.hello',
        component: require('./components/Hello.vue')
    },
    {
        path: '/vue/count',
        name: 'vue.count',
        component: require('./components/Count.vue')
    },
    {
    	path: '/vue/article/:id',
    	name: 'vue.article',
    	component: require('./components/Article.vue')
    },
    {
    	path: '/vue/draggable',
    	name: 'vue.draggable',
    	component: require('./components/Draggable.vue')
    },
];

//Router Instance
const router = new VueRouter({
    mode: 'history',
    routes: routes,
});

//Router Guard
router.beforeEach((to, from, next) => {
	next()
})

export default router
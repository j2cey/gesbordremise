import VueRouter from 'vue-router';


let routes = [
    {
        name: 'dashboard',
        path: '/dashboard',
        component: require('./views/dashboard').default
    },
    {
        name: 'bordereauremises.index',
        path: '/bordereauremises',
        component: require('./views/bordereauremises/index').default
    },
    {
        name: 'workflows.index',
        path: '/workflows',
        component: require('./views/workflows/index').default
    }
];

export default new VueRouter({
    base: '/',
    mode: 'history',
    routes,
    linkActiveClass: 'active'
});

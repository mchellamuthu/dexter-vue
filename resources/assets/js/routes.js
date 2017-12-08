import VueRouter from 'vue-router';

let routes = [
    {
        path: '/',
        component: require('./views/Home'),
        meta: { forGuest: true }
    },
    {
        path: '/users',
        component: require('./views/Users'),
        meta: { forGuest: true }
    },
    {
        path: '/user/:userId',
        name: 'user',
        component: require('./views/User'),
        props:true

    },
    {
      path: '/institute/:instituteId',
      name: 'institute',
      component: require('./views/Institute'),
      props: true
    }

];

export default new VueRouter({
    routes,
    linkActiveClass: 'is-active'
});

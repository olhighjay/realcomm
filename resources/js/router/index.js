import Hello from '../views/category'
import Home from '../views/home'

export default{
    mode: 'history',
    routes: [
        {
            path: '/ham',
            name: 'home',
            component: Home
        },
        // {
        //     path: '/category',
        //     name: 'category',
        //     component: Hello,
        // },
    ],
};
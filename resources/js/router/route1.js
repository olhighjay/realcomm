import Hello from '../views/category'

export default{
  mode: 'history',
  routes: [
    {
      path: '/category',
      name: 'category',
      component: Hello,
    },
  ],
};
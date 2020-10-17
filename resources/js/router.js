import Router from 'vue-router';

import Dashboard from './pages/Dashboard'
import Settings from './pages/Settings'
import Users from './pages/Users'
import Roles from './pages/Roles'
import Permissions from './pages/Permissions'
import Activities from './pages/Activities'

// import messagesRoutes from '@/modules/messages/router';
// import peopleRoutes from '@/modules/people/router';


const baseRoutes = [
  {
      path: '/admin/dashboard',
      component: Dashboard
  },
  {
      path: '/admin/users',
      component: Users
  },
  {
      path: '/admin/roles',
      component: Roles
  },
  {
      path: '/admin/permissions',
      component: Permissions
  },
  {
      path: '/admin/settings',
      component: Settings
  },
  {
      path: '/admin/activities',
      component: Activities
  },
  // {
  //   path: '*',
  //   redirect: {
  //     name: 'home',
  //   },
  // },
];

// const routes = baseRoutes.concat(messagesRoutes, peopleRoutes);
const routes = baseRoutes;
export default new Router({
  mode: 'history',
  routes,
});


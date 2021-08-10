import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from "./views/Home";
import TsumiageCreate from "./views/TsumiageCreate";
import TsumiageEdit from "./views/TsumiageEdit";
import Reports from "./views/Reports";
import ItemsEdit from "./views/ItemsEdit";
import Logout from "./Actions/Logout";
import Chart from "./components/Chart";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            path: '/home', component: Home,
            meta: { title: 'ホーム' }
        }, {
            path: '/tsumiage/create/:day', component: TsumiageCreate,
            meta: { title: '積み上げ作成' }
        }, {
            path: '/tsumiage/edit/:day', component: TsumiageEdit,
            meta: { title: '積み上げ編集' }
        }, {
            path: '/items/:id/edit', component: ItemsEdit,
            meta: { title: '積み上げ項目編集' }
        }, {    
            path: '/reports', component: Reports,
            meta: { title: '積み上げ集計' }
        }, {
            path: '/chart', component: Chart,
            meta: { title: 'チャートサンプル' }
        }, {
            path: '/logout', component: Logout
        }
    ],
    mode: 'history'
});

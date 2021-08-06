import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from "./views/Home";
import TsumiageCreate from "./views/TsumiageCreate";
import ContactsShow from "./views/ContactsShow";
import TsumiageEdit from "./views/TsumiageEdit";
import ContactsIndex from "./views/ContactsIndex";
import BirthdaysIndex from "./views/BirthdaysIndex";
import ItemsEdit from "./views/ItemsEdit";
import Logout from "./Actions/Logout";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            path: '/home', component: Home,
            meta: { title: 'ホーム' }
        }, {
            path: '/contacts', component: ContactsIndex,
            meta: { title: 'Contacts' }
        }, {
            path: '/tsumiage/create', component: TsumiageCreate,
            meta: { title: '積み上げ作成' }
        }, {
            path: '/contacts/:id', component: ContactsShow, name: 'ContactsShow',
            meta: { title: '積み上げ詳細' }
        }, {
            path: '/tsumiage/:id/edit', component: TsumiageEdit,
            meta: { title: '積み上げ編集' }
        }, {
            path: '/items/:id/edit', component: ItemsEdit,
            meta: { title: '積み上げ項目編集' }
        }, {    
            path: '/birthdays', component: BirthdaysIndex,
            meta: { title: '積み上げ集計' }
        }, {
            path: '/logout', component: Logout
        }
    ],
    mode: 'history'
});

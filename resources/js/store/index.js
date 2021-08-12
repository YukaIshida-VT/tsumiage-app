import Vue from 'vue';
import Vuex from 'vuex';
import User from './modules/user';
import TodayTsumiage from './modules/todayTsumiage';
import userAgent from './modules/userAgent';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        User,
        TodayTsumiage,
        userAgent
    }
});
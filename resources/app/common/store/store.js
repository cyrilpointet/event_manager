import Vue from "vue";
import Vuex from "vuex";
import { userStore } from "@/user/store/userStore";

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        user: userStore,
    },
});

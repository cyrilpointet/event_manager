import Vue from "vue";
import Vuex from "vuex";
import { userStore } from "@/user/store/userStore";
import { teamStore } from "@/team/store/teamStore";
import { happeningStore } from "@/happening/store/happeningStore";

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        user: userStore,
        team: teamStore,
        happening: happeningStore,
    },
});

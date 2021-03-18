<template>
    <v-app>
        <div class="primary pa-2">
            <div class="d-flex align-center container">
                <p class="ma-0">navbar</p>
                <span class="flex-grow-1"></span>
                <Logout v-if="isLogged" />
            </div>
        </div>

        <div>
            <transition :name="transitionName" mode="out-in">
                <router-view />
            </transition>
        </div>
        <MsgDisplayer />
    </v-app>
</template>

<script>
import Vue from "vue";
import { mapGetters, mapState } from "vuex";
import MsgDisplayer from "@/common/component/MsgDisplayer";
import Logout from "@/user/component/Logout";

export default Vue.extend({
    name: "app",
    components: { MsgDisplayer, Logout },
    computed: {
        ...mapState({
            user: (state) => state.user.user,
        }),
        ...mapGetters({
            isLogged: "user/isLogged",
        }),
    },
    data() {
        return {
            name: null,
        };
    },
});
</script>

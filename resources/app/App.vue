<template>
    <v-app style="background-color: #f5f5f5">
        <div class="primary pa-2">
            <div class="d-flex align-center container">
                <router-link to="/">
                    <span class="ma-0 font-weight-bold black--text">
                        Event Manager
                    </span>
                </router-link>
                <span class="flex-grow-1"></span>
                <v-menu offset-y v-if="isLogged">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn icon v-bind="attrs" v-on="on">
                            <v-icon>mdi-account</v-icon>
                        </v-btn>
                    </template>
                    <v-list>
                        <v-list-item>
                            <router-link
                                to="/account"
                                class="text-decoration-none"
                            >
                                <span class="black--text">Mon compte</span>
                            </router-link>
                        </v-list-item>
                        <v-list-item @click="logout">Déconnexion</v-list-item>
                    </v-list>
                </v-menu>
            </div>
        </div>

        <div class="container mainView pt-4">
            <router-view />
            <div>
                <div style="height: auto">
                    <v-calendar />
                </div>
            </div>
        </div>
        <MsgDisplayer />
        <ConfirmModal />
    </v-app>
</template>

<script>
import Vue from "vue";
import { mapGetters, mapState } from "vuex";
import MsgDisplayer from "@/common/component/MsgDisplayer";
import ConfirmModal from "@/common/component/ConfirmModal";

export default Vue.extend({
    name: "app",
    components: { MsgDisplayer, ConfirmModal },
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
    methods: {
        logout() {
            this.$store.dispatch("user/logout");
            if (this.$route.name !== "account") {
                this.$router.push({ name: "account" });
            }
        },
    },
});
</script>

<style lang="scss" scoped>
.link {
    text-decoration: none;
}
</style>

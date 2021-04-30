<template>
    <div>
        <div v-if="isLogged">
            <Account />

            <div class="ma-4 d-flex justify-center">
                <v-btn @click="logout" color="error">Déconnexion</v-btn>
            </div>
        </div>
        <div v-else>
            <transition name="fade" mode="out-in">
                <v-card v-if="hasAccount" key="Login">
                    <v-card-title>Me connecter</v-card-title>
                    <v-card-text>
                        <Login />
                    </v-card-text>
                </v-card>

                <v-card v-if="!hasAccount" key="Register">
                    <v-card-title>Créer mon compte</v-card-title>
                    <v-card-text>
                        <Register />
                    </v-card-text>
                </v-card>
            </transition>

            <div class="d-flex justify-center pa-6">
                <v-btn small color="primary" @click="hasAccount = !hasAccount">
                    {{
                        hasAccount
                            ? "Je n'ai pas de compte"
                            : "J'ai déjà un compte"
                    }}
                </v-btn>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";

import Login from "@/user/component/Login";
import Register from "@/user/component/Register";
import Account from "@/user/component/Account";

export default {
    name: "UserPage",
    components: { Login, Register, Account },
    data() {
        return {
            hasAccount: false,
        };
    },
    computed: {
        ...mapState({
            user: (state) => state.user.user,
        }),
        ...mapGetters({
            isLogged: "user/isLogged",
        }),
    },
    methods: {
        logout() {
            this.$store.dispatch("user/logout");
            if (this.$route.name !== "account") {
                this.$router.push({ name: "account" });
            }
        },
    },
};
</script>

<template>
    <div class="primary pa-2" v-if="isLogged && user">
        <div class="d-flex align-center container">
            <router-link to="/">
                <span class="ma-0 font-weight-bold black--text">
                    Event Manager
                </span>
            </router-link>
            <span class="flex-grow-1"></span>
            <v-btn
                fab
                small
                outlined
                class="ml-2"
                @click="$router.push({ name: 'home' })"
            >
                <v-icon>mdi-home</v-icon>
            </v-btn>
            <v-badge
                :content="user.invitations.length"
                :value="user.invitations.length > 0"
                color="error"
                overlap
            >
                <v-btn
                    fab
                    small
                    outlined
                    class="ml-2"
                    @click="$router.push({ name: 'teams' })"
                >
                    <v-icon>mdi-account-multiple</v-icon>
                </v-btn>
            </v-badge>
            <v-btn
                fab
                small
                outlined
                class="ml-2"
                @click="$router.push({ name: 'account' })"
            >
                <v-icon>mdi-account</v-icon>
            </v-btn>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";

export default {
    name: "HeaderMobile",
    computed: {
        ...mapGetters({
            isLogged: "user/isLogged",
        }),
        ...mapState({
            user: (state) => state.user.user,
        }),
    },
};
</script>

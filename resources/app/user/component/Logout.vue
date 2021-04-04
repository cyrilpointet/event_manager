<template>
    <v-btn :icon="isIcon" @click="logout">
        <span v-if="!isIcon">Déconnexion</span>
        <v-icon v-else>mdi-account-cancel</v-icon>
    </v-btn>
</template>

<script>
export default {
    name: "Logout",
    props: ["icon"],
    computed: {
        isIcon() {
            return undefined !== this.icon;
        },
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

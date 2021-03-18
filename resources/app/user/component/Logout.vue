<template>
    <v-btn icon @click="logout">
        <v-icon>mdi-account-cancel</v-icon>
    </v-btn>
</template>

<script>
export default {
    name: "Logout",
    methods: {
        logout() {
            this.$store.dispatch("user/logout");
            this.$router.push({ name: "account" });
        },
    },
};
</script>

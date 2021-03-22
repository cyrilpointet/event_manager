<template>
    <div>
        <h1 class="text-center">Mon compte</h1>
        <p>Nom: {{ user.name }}</p>
        <p>Email: {{ user.email }}</p>
        <p>Inscription: {{ user.createdAt }}</p>
        <div class="text-center">
            <Logout />
        </div>
    </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";
import Logout from "@/user/component/Logout";

export default {
    name: "Account",
    components: { Logout },
    computed: {
        ...mapState({
            user: (state) => state.user.user,
        }),
        ...mapGetters({
            isLogged: "user/isLogged",
        }),
    },
};
</script>

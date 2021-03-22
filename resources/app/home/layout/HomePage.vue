<template>
    <div class="container">
        <h1 class="text-center">Homepage</h1>
        <h2>
            Bienvenue <span v-if="isLogged">{{ user.name }}</span>
        </h2>
    </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";

export default {
    name: "Home",
    components: {},
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

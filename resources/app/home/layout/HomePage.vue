<template>
    <div class="container">
        <h1>
            Bienvenue <span v-if="isLogged">{{ user.name }}</span>
        </h1>
        <p>homepage</p>
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

<template>
    <div>coucouc</div>
</template>

<script>
import { mapGetters, mapState } from "vuex";

export default {
    name: "UserAccount",
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

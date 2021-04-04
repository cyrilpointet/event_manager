<template>
    <div class="container">
        <h1 class="text-center">Homepage</h1>
        <h2>
            Bienvenue <span v-if="isLogged">{{ user.name }}</span>
        </h2>
        <div v-if="isLogged && user">
            <TeamViewer />
            <CreateTeam />
        </div>
    </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";
import CreateTeam from "@/user/component/CreateTeam";
import TeamViewer from "@/user/component/TeamsViewer";

export default {
    name: "Home",
    components: { CreateTeam, TeamViewer },
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

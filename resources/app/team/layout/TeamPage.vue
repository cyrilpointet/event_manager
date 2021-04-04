<template>
    <div class="container">
        <div v-if="!isLogged || !team">loading...</div>
        <div v-else>
            <h1>{{ team.name }}</h1>
            <p>Créé le : {{ team.createdAt }}</p>
            <v-btn v-if="isUserAdmin" @click="deleteTeam">supprimer</v-btn>
            <MembersViewer />
        </div>
    </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";
import MembersViewer from "@/team/component/MembersViewer";
import { ApiConsumer } from "@/common/services/ApiConsumer";

export default {
    name: "TeamPage",
    components: { MembersViewer },
    computed: {
        ...mapState({
            user: (state) => state.user.user,
            team: (state) => state.team.team,
        }),
        ...mapGetters({
            isLogged: "user/isLogged",
            isUserAdmin: "team/isUserAdmin",
        }),
    },
    created() {
        if (!this.team || this.$route.params.id !== this.team.id) {
            this.$store.dispatch("team/getTeamById", this.$route.params.id);
        }
    },
    methods: {
        async deleteTeam() {
            await ApiConsumer.delete("team/" + this.team.id);
            this.$store.commit("user/removeTeam", this.team.id);
            this.$store.commit("team/removeTeam");
            this.$router.push({ name: "home" });
        },
    },
};
</script>

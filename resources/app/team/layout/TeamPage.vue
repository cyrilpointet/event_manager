<template>
    <div class="container">
        <div v-if="!isLogged || !team">loading...</div>
        <div v-else>
            <h1>{{ team.name }}</h1>
            <p>Créé le : {{ team.createdAt }}</p>
            <v-btn v-if="isUserAdmin" @click="deleteTeam">supprimer</v-btn>
            <v-btn v-if="!isUserAdmin" @click="leaveTeam">Quitter</v-btn>
            <MembersViewer v-if="!isUserAdmin" />
            <MembersManager v-if="isUserAdmin"></MembersManager>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";
import { ApiConsumer } from "@/common/services/ApiConsumer";
import MembersViewer from "@/team/component/MembersViewer";
import MembersManager from "@/team/component/MembersManager";

export default {
    name: "TeamPage",
    components: { MembersViewer, MembersManager },
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
            try {
                await ApiConsumer.delete("team/" + this.team.id);
                this.$store.commit("user/removeTeam", this.team.id);
                this.$store.commit("team/removeTeam");
                this.$router.push({ name: "home" });
            } catch {
                const event = new CustomEvent("displayMsg", {
                    detail: {
                        text: "Oups...",
                        color: "error",
                    },
                });
                document.dispatchEvent(event);
            }
        },

        async leaveTeam() {
            try {
                await ApiConsumer.delete(`team/${this.team.id}/leave`);
                this.$store.commit("user/removeTeam", this.team.id);
                this.$store.commit("team/removeTeam");
                this.$router.push({ name: "home" });
            } catch {
                const event = new CustomEvent("displayMsg", {
                    detail: {
                        text: "Oups...",
                        color: "error",
                    },
                });
                document.dispatchEvent(event);
            }
        },
    },
};
</script>

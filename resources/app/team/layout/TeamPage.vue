<template>
    <div>
        <div v-if="!isLogged || !team">loading...</div>
        <div v-else>
            <v-card class="mb-4">
                <v-card-title>{{ team.name }}</v-card-title>
                <v-card-text>Créé le : {{ team.createdAt }}</v-card-text>
                <v-card-actions>
                    <v-btn v-if="isUserAdmin" @click="askDeleteTeam">
                        supprimer
                    </v-btn>
                    <v-btn v-if="!isUserAdmin" @click="askLeaveTeam">
                        Quitter
                    </v-btn>
                </v-card-actions>
            </v-card>

            <v-card
                class="mb-4"
                v-if="isUserAdmin && team.invitations.length > 0"
            >
                <v-card-title>Demandes d'adhésion</v-card-title>
                <v-card-text>
                    <UserInvitationsManager />
                </v-card-text>
            </v-card>

            <v-card class="mb-4">
                <v-card-title>Membres</v-card-title>
                <v-card-text>
                    <MembersViewer v-if="!isUserAdmin" />
                    <MembersManager v-if="isUserAdmin" />
                </v-card-text>
            </v-card>

            <v-card class="mb-4" v-if="isUserAdmin">
                <v-card-title>Ajouter un membre</v-card-title>
                <v-card-text>
                    <UserFinder />
                </v-card-text>
            </v-card>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";
import { ApiConsumer } from "@/common/services/ApiConsumer";
import MembersViewer from "@/team/component/MembersViewer";
import MembersManager from "@/team/component/MembersManager";
import UserFinder from "@/team/component/UserFinder";
import UserInvitationsManager from "@/team/component/UserInvitationsManager";

export default {
    name: "TeamPage",
    components: {
        MembersViewer,
        MembersManager,
        UserFinder,
        UserInvitationsManager,
    },
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
    async created() {
        if (!this.team || this.$route.params.id !== this.team.id) {
            try {
                await this.$store.dispatch(
                    "team/getTeamById",
                    this.$route.params.id
                );
            } catch {
                this.$router.push({ name: "home" });
            }
        }
    },
    methods: {
        askDeleteTeam() {
            const event = new CustomEvent("confirmAction", {
                detail: {
                    title: `Supprimer ce groupe ?`,
                    text: "Cette action est irréversible",
                    callback: () => {
                        this.deleteTeam();
                    },
                },
            });
            document.dispatchEvent(event);
        },

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

        askLeaveTeam() {
            const event = new CustomEvent("confirmAction", {
                detail: {
                    title: `Quitter ce groupe ?`,
                    text: "Cette action est irréversible",
                    callback: () => {
                        this.leaveTeam();
                    },
                },
            });
            document.dispatchEvent(event);
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

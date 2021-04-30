<template>
    <div>
        <div v-if="isLogged && user">
            <v-card class="mb-4" v-if="user.invitations.length > 0">
                <v-card-title>Invitations</v-card-title>
                <v-card-text>
                    <TeamInvitationsManager />
                </v-card-text>
            </v-card>

            <v-card class="mb-4">
                <v-card-title>Mes groupes</v-card-title>
                <v-card-text>
                    <TeamViewer />
                </v-card-text>
            </v-card>

            <v-card class="mb-4">
                <v-card-title>Créer un groupe</v-card-title>
                <v-card-text>
                    <CreateTeam />
                </v-card-text>
            </v-card>

            <v-card class="mb-4">
                <v-card-title>Chercher un groupe</v-card-title>
                <v-card-text>
                    <TeamFinder />
                </v-card-text>
            </v-card>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";
import CreateTeam from "@/team/component/CreateTeam";
import TeamViewer from "@/user/component/TeamsViewer";
import TeamFinder from "@/invitation/component/TeamFinder";
import TeamInvitationsManager from "@/invitation/component/TeamInvitationsManager";

export default {
    name: "TeamsPage",
    components: {
        CreateTeam,
        TeamViewer,
        TeamFinder,
        TeamInvitationsManager,
    },
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

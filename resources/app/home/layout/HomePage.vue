<template>
    <div>
        <div v-if="isLogged && user">
            <v-card class="mb-4" v-if="user.invitations.length > 0">
                <v-card-title>Demandes d'adhésion</v-card-title>
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
import CreateTeam from "@/user/component/CreateTeam";
import TeamViewer from "@/user/component/TeamsViewer";
import TeamFinder from "@/user/component/TeamFinder";
import TeamInvitationsManager from "@/user/component/TeamInvitationsManager";

export default {
    name: "Home",
    components: { CreateTeam, TeamViewer, TeamFinder, TeamInvitationsManager },
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

<template>
    <div>
        <v-card class="mb-4">
            <v-card-title>
                {{ user.name }}
            </v-card-title>
            <v-card-text>
                <p>Email: {{ user.email }}</p>
                <p>Inscription: {{ user.createdAt }}</p>
            </v-card-text>
        </v-card>

        <v-card class="mb-4">
            <v-card-title>Prochains évènements</v-card-title>
            <v-card-text>
                <NextUserHappenings />
            </v-card-text>
        </v-card>

        <v-card class="mt-4">
            <v-card-title>Mes groupes</v-card-title>
            <v-card-text>
                <TeamViewer />
            </v-card-text>
        </v-card>

        <v-card class="mt-4" v-if="user.invitations.length > 0">
            <v-card-title>Invitations</v-card-title>
            <v-card-text>
                <TeamInvitationsManager />
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";
import TeamViewer from "@/user/component/TeamsViewer";
import TeamInvitationsManager from "@/invitation/component/TeamInvitationsManager";
import NextUserHappenings from "@/user/component/NextUserHappenings";

export default {
    name: "Account",
    components: { TeamViewer, TeamInvitationsManager, NextUserHappenings },
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

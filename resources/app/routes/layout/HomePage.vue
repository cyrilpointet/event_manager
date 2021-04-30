<template>
    <div>
        <div v-if="isLogged && user">
            <v-card class="mb-4" v-if="user.invitations.length > 0">
                <v-card-title>Invitations</v-card-title>
                <v-card-text>
                    <TeamInvitationsManager />
                </v-card-text>
            </v-card>

            <v-card class="mb-4" v-if="user.upcomingHappenings.length > 0">
                <v-card-title>Prochains évènements</v-card-title>
                <v-card-text>
                    <NextUserHappenings />
                </v-card-text>
            </v-card>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";
import TeamInvitationsManager from "@/invitation/component/TeamInvitationsManager";
import NextUserHappenings from "@/user/component/NextUserHappenings";

export default {
    name: "Home",
    components: {
        TeamInvitationsManager,
        NextUserHappenings,
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

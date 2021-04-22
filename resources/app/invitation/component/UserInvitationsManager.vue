<template>
    <div>
        <template v-for="(invitation, index) in team.invitations">
            <div
                v-if="invitation.isFromTeam !== true"
                :key="invitation.id"
                class="d-flex flex-wrap align-center py-2"
                :class="
                    index !== team.invitations.length - 1 ? 'underline' : ''
                "
            >
                <p class="flex-grow-1 ma-0">{{ invitation.userEmail }}</p>
                <div>
                    <v-btn
                        text
                        x-small
                        color="primary"
                        :disabled="ajaxPending"
                        @click="manageInvitation(invitation.id, true)"
                    >
                        Accepter
                    </v-btn>

                    <v-btn
                        text
                        x-small
                        color="error"
                        :disabled="ajaxPending"
                        @click="manageInvitation(invitation.id, false)"
                    >
                        Refuser
                    </v-btn>
                </div>
            </div>
        </template>
        <div v-if="team.invitations.length < 1">
            <p>Aucune demande en cours</p>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import { ApiConsumer } from "@/common/services/ApiConsumer";
import { Team } from "@/team/model/Team";

export default {
    name: "UserInvitationsManager",
    data: () => {
        return {
            ajaxPending: false,
        };
    },
    computed: {
        ...mapState({
            team: (state) => state.team.team,
        }),
    },
    methods: {
        async manageInvitation(invitationId, status) {
            this.ajaxPending = true;
            const updatedTeam = await ApiConsumer.put(
                `team/${this.team.id}/invitation/${invitationId}`,
                {
                    status: status,
                }
            );
            this.$store.commit("team/setTeam", new Team(updatedTeam));
            this.ajaxPending = false;
        },
    },
};
</script>

<style scoped lang="scss">
.underline {
    border-bottom: 1px solid lightgray;
}
</style>

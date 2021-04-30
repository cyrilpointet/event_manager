<template>
    <div>
        <template v-for="(invitation, index) in user.invitations">
            <div
                v-if="invitation.isFromTeam === true"
                :key="invitation.id"
                class="d-flex flex-wrap align-center"
                :class="
                    index !== user.invitations.length - 1 ? 'underline' : ''
                "
            >
                <p class="flex-grow-1 ma-0">{{ invitation.team.name }}</p>
                <div>
                    <v-btn
                        x-small
                        rounded
                        color="primary"
                        :disabled="ajaxPending"
                        @click="manageInvitation(invitation.id, true)"
                    >
                        Rejoindre
                    </v-btn>

                    <v-btn
                        rounded
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
        <div v-if="user.invitations.length < 1">
            <p>Aucune demande en cours</p>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import { ApiConsumer } from "@/common/services/ApiConsumer";
import { User } from "@/user/model/User";

export default {
    name: "TeamInvitationsManager",
    data: () => {
        return {
            ajaxPending: false,
        };
    },
    computed: {
        ...mapState({
            user: (state) => state.user.user,
        }),
    },
    methods: {
        async manageInvitation(invitationId, status) {
            this.ajaxPending = true;
            const updatedUser = await ApiConsumer.put(
                `user/invitation/${invitationId}`,
                {
                    status: status,
                }
            );
            this.$store.commit("user/setUser", new User(updatedUser));
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

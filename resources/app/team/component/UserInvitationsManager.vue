<template>
    <div>
        <h4>Demandes d'adhésion</h4>
        <v-simple-table>
            <template v-slot:default>
                <tbody>
                    <template v-for="invitation in team.invitations">
                        <tr
                            v-if="invitation.isFromTeam !== true"
                            :key="invitation.id"
                        >
                            <td>{{ invitation.userEmail }}</td>
                            <td>
                                <v-btn
                                    icon
                                    color="primary"
                                    :disabled="ajaxPending"
                                    @click="
                                        manageInvitation(invitation.id, true)
                                    "
                                >
                                    <v-icon>mdi-account</v-icon>
                                </v-btn>
                            </td>
                            <td>
                                <v-btn
                                    icon
                                    color="error"
                                    :disabled="ajaxPending"
                                    @click="
                                        manageInvitation(invitation.id, false)
                                    "
                                >
                                    <v-icon>mdi-delete</v-icon>
                                </v-btn>
                            </td>
                        </tr>
                    </template>
                    <tr v-if="team.invitations.length < 1">
                        <td>Aucune demande en cours</td>
                    </tr>
                </tbody>
            </template>
        </v-simple-table>
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

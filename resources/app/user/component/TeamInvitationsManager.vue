<template>
    <div>
        <h4>Demandes d'adhésion</h4>
        <v-simple-table>
            <template v-slot:default>
                <tbody>
                    <template v-for="invitation in user.invitations">
                        <tr
                            v-if="invitation.isFromTeam === true"
                            :key="invitation.id"
                        >
                            <td>{{ invitation.team.name }}</td>
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
                    <tr v-if="user.invitations.length < 1">
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

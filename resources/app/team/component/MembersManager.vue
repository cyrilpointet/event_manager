<template>
    <v-simple-table>
        <template v-slot:default>
            <thead>
                <tr>
                    <th class="text-left">Nom</th>
                    <th class="text-left">Admin</th>
                    <th class="text-left">Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="member in team.members" :key="member.id">
                    <td>{{ member.name }}</td>
                    <td>
                        <v-switch
                            :input-value="member.isAdmin"
                            :disabled="
                                (team.adminCount < 2 &&
                                    user.id === member.id) ||
                                ajaxPending
                            "
                            @change="toggleAdmin(member)"
                        />
                    </td>
                    <td>
                        <v-btn
                            icon
                            v-if="isUserAdmin && member.id !== user.id"
                            color="error"
                            @click="askRemoveMember(member)"
                            :disabled="ajaxPending"
                        >
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                    </td>
                </tr>
            </tbody>
        </template>
    </v-simple-table>
</template>

<script>
import { mapGetters, mapState } from "vuex";
import { Team } from "@/team/model/Team";
import { ApiConsumer } from "@/common/services/ApiConsumer";

export default {
    name: "MembersManager",
    data: () => {
        return {
            ajaxPending: false,
        };
    },
    computed: {
        ...mapState({
            team: (state) => state.team.team,
            user: (state) => state.user.user,
        }),
        ...mapGetters({
            isUserAdmin: "team/isUserAdmin",
        }),
    },
    methods: {
        async toggleAdmin(member) {
            this.ajaxPending = true;
            try {
                const team = await ApiConsumer.put(
                    `team/${this.team.id}/admin`,
                    {
                        memberId: member.id,
                        admin: !member.isAdmin,
                    }
                );
                this.$store.commit("team/setTeam", new Team(team));
            } catch (error) {
                const event = new CustomEvent("displayMsg", {
                    detail: {
                        text: "Oups... Une erreur est survenue !",
                        color: "error",
                    },
                });
                document.dispatchEvent(event);
            }
            this.ajaxPending = false;
        },

        askRemoveMember(member) {
            const event = new CustomEvent("confirmAction", {
                detail: {
                    title: `Supprimer ${member.name} du groupe ?`,
                    text: "Cette action est irréversible",
                    callback: () => {
                        this.removeMember(member);
                    },
                },
            });
            document.dispatchEvent(event);
        },

        async removeMember(member) {
            this.ajaxPending = true;
            try {
                const team = await ApiConsumer.delete(
                    `team/${this.team.id}/member/${member.id}`
                );
                this.$store.commit("team/setTeam", new Team(team));
            } catch (error) {
                console.log(error);
                const event = new CustomEvent("displayMsg", {
                    detail: {
                        text: "Oups... Une erreur est survenue !",
                        color: "error",
                    },
                });
                document.dispatchEvent(event);
            }
            this.ajaxPending = false;
        },
    },
};
</script>

<template>
    <div>
        <v-simple-table>
            <template v-slot:default>
                <thead>
                    <tr>
                        <th class="text-left">Nom</th>
                        <th class="text-left">Invité</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="member in members" :key="member.id">
                        <td>
                            {{ member.name }}
                        </td>
                        <td>
                            <v-switch
                                v-model="member.isInvited"
                                :disabled="
                                    (member.isInvited && member.isAdmin) ||
                                    ajaxPending
                                "
                                @change="updateParticipation(member)"
                            />
                        </td>
                    </tr>
                </tbody>
            </template>
        </v-simple-table>
    </div>
</template>

<script>
import { mapState } from "vuex";

export default {
    name: "HappeningMembersManager",
    data: () => {
        return {
            members: [],
            ajaxPending: false,
        };
    },
    computed: {
        ...mapState({
            user: (state) => state.user.user,
            team: (state) => state.team.team,
            happening: (state) => state.happening.happening,
        }),
    },
    created() {
        this.init();
    },
    methods: {
        init() {
            const members = [];
            this.team.members.forEach((teamMember) => {
                const member = {
                    name: teamMember.name,
                    id: teamMember.id,
                    isAdmin: teamMember.isAdmin,
                    isInvited: false,
                };
                if (
                    this.happening.members.findIndex(
                        (elem) => elem.id === teamMember.id
                    ) !== -1
                ) {
                    member.isInvited = true;
                }
                members.push(member);
            });
            this.members = members;
        },
        async updateParticipation(member) {
            this.ajaxPending = true;
            try {
                if (member.isInvited) {
                    await this.$store.dispatch(
                        "happening/addMemberToHappening",
                        {
                            happeningId: this.happening.id,
                            userId: member.id,
                        }
                    );
                } else {
                    await this.$store.dispatch(
                        "happening/removeMemberFromHappening",
                        {
                            happeningId: this.happening.id,
                            userId: member.id,
                        }
                    );
                }
            } catch {
                const event = new CustomEvent("displayMsg", {
                    detail: {
                        text: "Oups... Une erreur est survenue !",
                        color: "error",
                    },
                });
                document.dispatchEvent(event);
            }

            this.init();
            this.ajaxPending = false;
        },
    },
};
</script>

<template>
    <v-simple-table>
        <template v-slot:default>
            <thead>
                <tr>
                    <th class="text-left">Nom</th>
                    <th class="text-left">Présence</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="member in happening.members" :key="member.id">
                    <td>{{ member.name }}</td>
                    <td
                        :class="`presence-${member.presence} text-center`"
                        v-if="member.id !== user.id"
                    >
                        <v-icon>{{ getPresenceIcon(member.presence) }}</v-icon>
                    </td>
                    <td
                        :class="`presence-${selfPresence} text-center`"
                        v-if="member.id === user.id"
                        class="d-flex align-center justify-center"
                    >
                        <v-select
                            :items="items"
                            v-model="selfPresence"
                            @change="updatePresence"
                        />
                    </td>
                </tr>
            </tbody>
        </template>
    </v-simple-table>
</template>

<script>
import { mapState } from "vuex";
import { HappeningHelper } from "@/happening/service/HappeningHelper";
import { ApiConsumer } from "@/common/services/ApiConsumer";
import { Happening } from "@/happening/model/Happening";

export default {
    name: "HappeningMembers",
    data: () => {
        return {
            selfPresence: 0,
            items: HappeningHelper.getSelectItems,
        };
    },
    created() {
        const selfUser = this.happening.members.find(
            (member) => member.id === this.user.id
        );
        this.selfPresence = selfUser.presence;
    },
    computed: {
        ...mapState({
            user: (state) => state.user.user,
            happening: (state) => state.happening.happening,
        }),
    },
    methods: {
        getPresenceIcon(presence) {
            return HappeningHelper.getPresenceIcon(presence);
        },
        async updatePresence() {
            console.log(this.selfPresence);
            try {
                const newHappening = await ApiConsumer.put(
                    `happening/${this.happening.id}/updateMemberPresence`,
                    {
                        presence: this.selfPresence,
                    }
                );
                this.$store.commit(
                    "happening/setHappening",
                    new Happening(newHappening)
                );
            } catch (e) {
                const event = new CustomEvent("displayMsg", {
                    detail: {
                        text: e.response.data.message,
                        color: "error",
                        timeout: 3000,
                    },
                });
                document.dispatchEvent(event);
            }
        },
    },
};
</script>

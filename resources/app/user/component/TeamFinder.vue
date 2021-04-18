<template>
    <div>
        <h4>Chercher un groupe</h4>
        <v-form ref="form">
            <v-text-field
                v-model="name"
                label="Nom"
                append-outer-icon="mdi-send"
                @click:append-outer="findTeam"
            />
        </v-form>
        <div v-if="teams !== null">
            <template v-for="(team, index) in teams">
                <v-divider :key="'divider' + team.id" v-if="index !== 0" />
                <v-list-item :key="team.id">
                    <v-list-item-content>
                        <v-list-item-title>
                            {{ team.name }}
                        </v-list-item-title>
                    </v-list-item-content>
                    <v-list-item-action>
                        <v-btn icon @click="inviteTeam(team)">
                            <v-icon color="primary"> mdi-account </v-icon>
                        </v-btn>
                    </v-list-item-action>
                </v-list-item>
            </template>
            <v-list-item v-if="teams.length < 1">
                <v-list-item-content>
                    <v-list-item-title>
                        Aucun résulat pour <strong>{{ name }}</strong>
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </div>
    </div>
</template>

<script>
import { ApiConsumer } from "@/common/services/ApiConsumer";
import { mapState } from "vuex";

export default {
    name: "TeamFinder",
    data: () => {
        return {
            valid: true,
            name: "",
            ajaxPending: false,
            teams: null,
        };
    },
    computed: {
        ...mapState({
            user: (state) => state.user.user,
        }),
    },
    watch: {
        name() {
            this.teams = null;
        },
    },
    methods: {
        async findTeam() {
            if (this.name !== "") {
                this.teams = await ApiConsumer.get("teams/" + this.name);
            }
        },
        async inviteTeam(group) {
            try {
                await ApiConsumer.post(`user/invitation`, {
                    team_id: group.id,
                });
                const event = new CustomEvent("displayMsg", {
                    detail: {
                        text: "invitation envoyée",
                        timeout: 3000,
                    },
                });
                document.dispatchEvent(event);
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

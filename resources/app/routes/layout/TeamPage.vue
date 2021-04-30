<template>
    <div>
        <div v-if="!isLogged || !team" class="d-flex justify-center">
            <v-progress-circular indeterminate color="primary" />
        </div>
        <div v-else>
            <v-card class="mb-4">
                <v-card-title>{{ team.name }}</v-card-title>
                <v-card-text>Créé le : {{ team.createdAt }}</v-card-text>
                <v-card-actions>
                    <v-btn v-if="isUserAdmin" @click="askDeleteTeam">
                        supprimer
                    </v-btn>
                    <v-btn v-if="!isUserAdmin" @click="askLeaveTeam">
                        Quitter
                    </v-btn>
                </v-card-actions>
            </v-card>

            <v-card
                class="mb-4"
                v-if="isUserAdmin && team.invitations.length > 0"
            >
                <v-card-title>Demandes d'adhésion</v-card-title>
                <v-card-text>
                    <UserInvitationsManager />
                </v-card-text>
            </v-card>

            <v-card class="mb-4">
                <v-card-title>Prochains évènements</v-card-title>
                <v-card-text>
                    <NextTeamHappenings />
                    <div
                        v-if="isUserAdmin && blankEvent"
                        class="d-flex justify-center mt-4"
                    >
                        <v-btn @click="isCreateHappeningOpen = true">
                            Créer un nouvel évènement
                        </v-btn>
                    </div>
                </v-card-text>
            </v-card>

            <v-card class="mb-4">
                <v-card-title>Membres</v-card-title>
                <v-card-text>
                    <MembersViewer v-if="!isUserAdmin" />
                    <MembersManager v-if="isUserAdmin" />
                </v-card-text>
            </v-card>

            <v-card class="mb-4" v-if="isUserAdmin">
                <v-card-title>Ajouter un membre</v-card-title>
                <v-card-text>
                    <UserFinder />
                </v-card-text>
            </v-card>
        </div>

        <v-dialog v-model="isCreateHappeningOpen" width="500">
            <v-card v-if="isUserAdmin && blankEvent">
                <v-card-title>Créer un évènement</v-card-title>
                <v-card-text>
                    <UpsertHappening :happening="blankEvent" />
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";
import { ApiConsumer } from "@/common/services/ApiConsumer";
import MembersViewer from "@/team/component/MembersViewer";
import MembersManager from "@/team/component/MembersManager";
import UserFinder from "@/invitation/component/UserFinder";
import UserInvitationsManager from "@/invitation/component/UserInvitationsManager";
import NextTeamHappenings from "@/team/component/NextTeamHappenings";
import UpsertHappening from "@/happening/component/UpsertHappening";
import { Happening } from "@/happening/model/Happening";
import * as dayjs from "dayjs";

export default {
    name: "TeamPage",
    components: {
        MembersViewer,
        MembersManager,
        UserFinder,
        UserInvitationsManager,
        NextTeamHappenings,
        UpsertHappening,
    },
    data: function () {
        return {
            blankEvent: null,
            isCreateHappeningOpen: false,
        };
    },
    computed: {
        ...mapState({
            user: (state) => state.user.user,
            team: (state) => state.team.team,
        }),
        ...mapGetters({
            isLogged: "user/isLogged",
            isUserAdmin: "team/isUserAdmin",
        }),
    },
    async created() {
        if (!this.team || this.$route.params.id !== this.team.id) {
            this.$store.commit("team/removeTeam");
            try {
                await this.$store.dispatch(
                    "team/getTeamById",
                    this.$route.params.id
                );
            } catch {
                this.$router.push({ name: "home" });
            }
        }

        const now = dayjs();
        this.blankEvent = new Happening({
            id: null,
            name: "",
            description: "",
            place: "",
            users: [],

            created_at: now.format("MM/DD/YYYY HH:mm:ss"),
            updated_at: now.format("MM/DD/YYYY HH:mm:ss"),
            start_at: now.format("MM/DD/YYYY HH:mm:ss"),
            end_at: now.format("MM/DD/YYYY HH:mm:ss"),

            status_id: 1,

            team: {
                id: this.team.id,
                name: this.team.name,
            },
        });
    },
    methods: {
        askDeleteTeam() {
            const event = new CustomEvent("confirmAction", {
                detail: {
                    title: `Supprimer ce groupe ?`,
                    text: "Cette action est irréversible",
                    callback: () => {
                        this.deleteTeam();
                    },
                },
            });
            document.dispatchEvent(event);
        },

        async deleteTeam() {
            try {
                await ApiConsumer.delete("team/" + this.team.id);
                this.$store.commit("user/removeTeam", this.team.id);
                this.$store.commit("team/removeTeam");
                this.$router.push({ name: "home" });
            } catch {
                const event = new CustomEvent("displayMsg", {
                    detail: {
                        text: "Oups... Une erreur est survenue !",
                        color: "error",
                    },
                });
                document.dispatchEvent(event);
            }
        },

        askLeaveTeam() {
            const event = new CustomEvent("confirmAction", {
                detail: {
                    title: `Quitter ce groupe ?`,
                    text: "Cette action est irréversible",
                    callback: () => {
                        this.leaveTeam();
                    },
                },
            });
            document.dispatchEvent(event);
        },

        async leaveTeam() {
            try {
                await ApiConsumer.delete(`team/${this.team.id}/leave`);
                this.$store.commit("user/removeTeam", this.team.id);
                this.$store.commit("team/removeTeam");
                this.$router.push({ name: "home" });
            } catch {
                const event = new CustomEvent("displayMsg", {
                    detail: {
                        text: "Oups... Une erreur est survenue !",
                        color: "error",
                    },
                });
                document.dispatchEvent(event);
            }
        },
    },
};
</script>

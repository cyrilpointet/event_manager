<template>
    <div>
        <div
            v-if="!isLogged || !happening || !team"
            class="d-flex justify-center"
        >
            <v-progress-circular indeterminate color="primary" />
        </div>
        <div v-else>
            <v-card class="mb-4">
                <v-card-title>{{ happening.name }}</v-card-title>
                <v-card-text>
                    <h5>Status</h5>
                    <p
                        class="text-capitalize"
                        :class="'status-' + happening.status_id"
                    >
                        {{ happening.status }}
                    </p>
                    <h5>Groupe</h5>
                    <div
                        v-ripple
                        @click="
                            $router.push({
                                name: 'team',
                                params: { id: team.id },
                            })
                        "
                        class="teamButton"
                    >
                        {{ happening.team.name }}
                        <v-icon> mdi-chevron-right </v-icon>
                    </div>

                    <h5>Début</h5>
                    <p>{{ happening.start }}</p>
                    <h5>Fin</h5>
                    <p>{{ happening.end }}</p>

                    <h5>Description</h5>
                    <p style="white-space: pre-line">
                        {{ happening.description }}
                    </p>
                    <h5>Lieu</h5>
                    <p style="white-space: pre-line">
                        {{ happening.place }}
                    </p>
                </v-card-text>
            </v-card>

            <v-btn
                v-if="isUserAdmin"
                @click="edit = !edit"
                class="mb-4"
                color="primary"
            >
                editer
            </v-btn>

            <v-btn
                v-if="isUserAdmin"
                @click="askDeleteHappening"
                class="mb-4"
                color="error"
            >
                Supprimer
            </v-btn>

            <v-dialog v-model="edit" width="500">
                <v-card v-if="isUserAdmin && edit">
                    <v-card-title>Modifier</v-card-title>
                    <v-card-text>
                        <UpsertHappening
                            :happening="happening"
                            @updated="edit = false"
                        />
                    </v-card-text>
                </v-card>
            </v-dialog>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";
import UpsertHappening from "@/happening/component/UpsertHappening";

export default {
    name: "HappeningPage",
    components: { UpsertHappening },
    data: () => {
        return {
            edit: false,
        };
    },
    computed: {
        ...mapState({
            happening: (state) => state.happening.happening,
            team: (state) => state.team.team,
        }),
        ...mapGetters({
            isLogged: "user/isLogged",
            isUserAdmin: "team/isUserAdmin",
        }),
    },
    async created() {
        if (!this.happening || this.$route.params.id !== this.happening.id) {
            this.$store.commit("happening/setHappening", null);
            try {
                await this.$store.dispatch(
                    "happening/getHappeningById",
                    this.$route.params.id
                );
            } catch {
                this.$router.push({ name: "home" });
            }
        }
        if (!this.team || this.team.id !== this.happening.team.id) {
            try {
                await this.$store.dispatch(
                    "team/getTeamById",
                    this.happening.team.id
                );
            } catch {
                this.$router.push({ name: "home" });
            }
        }
    },
    methods: {
        askDeleteHappening() {
            const event = new CustomEvent("confirmAction", {
                detail: {
                    title: `Supprimer cet évènement ?`,
                    text: "Cette action est irréversible",
                    callback: () => {
                        this.deleteHappening();
                    },
                },
            });
            document.dispatchEvent(event);
        },
        async deleteHappening() {
            try {
                await this.$store.dispatch(
                    "happening/deleteHappening",
                    this.happening.id
                );
                this.$store.commit("team/removeTeam");
                const event = new CustomEvent("displayMsg", {
                    detail: {
                        text: "Evènement supprimé",
                    },
                });
                document.dispatchEvent(event);
                this.$router.push({ name: "home" });
            } catch {
                const event = new CustomEvent("displayMsg", {
                    detail: {
                        text: "Oups...",
                        color: "error",
                    },
                });
                document.dispatchEvent(event);
            }
        },
    },
};
</script>

<style lang="scss" scoped>
.teamButton {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem;
    cursor: pointer;
    transition: background-color linear 0.1s;
    &:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }
}
</style>

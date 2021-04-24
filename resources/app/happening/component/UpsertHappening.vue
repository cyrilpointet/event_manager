<template>
    <div>
        <v-form ref="form" v-model="valid">
            <v-text-field
                v-model="name"
                label="Nom"
                :rules="[rules.required]"
            />

            <v-text-field v-model="description" label="Description" />

            <v-text-field v-model="place" label="Lieu" />

            <div class="d-flex">
                <v-menu
                    v-model="startDateMenuOpen"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            :value="
                                new Date(startDate).toLocaleDateString('fr-FR')
                            "
                            label="Date de début"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                    </template>
                    <v-date-picker
                        v-model="startDate"
                        locale="fr"
                        @input="startDateMenuOpen = false"
                    ></v-date-picker>
                </v-menu>
                <v-menu
                    ref="menuStart"
                    v-model="startTimeMenuOpen"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    :return-value.sync="startTime"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            v-model="startTime"
                            label="Heure de début"
                            prepend-icon="mdi-clock-time-four-outline"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                        />
                    </template>
                    <v-time-picker
                        v-if="startTimeMenuOpen"
                        v-model="startTime"
                        locale="fr"
                        format="24hr"
                        @click:minute="$refs.menuStart.save(startTime)"
                    />
                </v-menu>
            </div>

            <div class="d-flex">
                <v-menu
                    v-model="endDateMenuOpen"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            :value="
                                new Date(endDate).toLocaleDateString('fr-FR')
                            "
                            label="Date de fin"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                    </template>
                    <v-date-picker
                        v-model="endDate"
                        locale="fr"
                        @input="endDateMenuOpen = false"
                    ></v-date-picker>
                </v-menu>
                <v-menu
                    ref="menuEnd"
                    v-model="endTimeMenuOpen"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    :return-value.sync="endTime"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            v-model="endTime"
                            label="Heure de fin"
                            prepend-icon="mdi-clock-time-four-outline"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                        />
                    </template>
                    <v-time-picker
                        v-if="endTimeMenuOpen"
                        v-model="endTime"
                        locale="fr"
                        format="24hr"
                        @click:minute="$refs.menuEnd.save(endTime)"
                    />
                </v-menu>
            </div>

            <v-radio-group v-model="status" row>
                <v-radio label="Projet" :value="1"></v-radio>
                <v-radio label="Validé" :value="2" color="succes"></v-radio>
                <v-radio label="Annulé" :value="3" color="error"></v-radio>
            </v-radio-group>

            <v-btn
                color="primary"
                :disabled="disablingButton"
                :loading="ajaxPending"
                @click="upsertHappening"
            >
                ok
            </v-btn>
        </v-form>
    </div>
</template>

<script>
import { formValidators } from "@/common/services/formValidators";
import { mapState } from "vuex";

export default {
    name: "UpsertHappening",
    props: ["happening"],
    data: function () {
        return {
            valid: true,
            happeningId: this.happening.id,
            name: this.happening.name,
            description: this.happening.description,
            place: this.happening.place,
            startDate: this.happening._start_at.format("YYYY-MM-DD"),
            startDateMenuOpen: false,
            startTime: this.happening._start_at.format("HH:mm"),
            startTimeMenuOpen: false,
            endDate: this.happening._end_at.format("YYYY-MM-DD"),
            endDateMenuOpen: false,
            endTime: this.happening._end_at.format("HH:mm"),
            endTimeMenuOpen: false,
            status: this.happening.status_id,
            ajaxPending: false,
            rules: formValidators,
        };
    },
    computed: {
        ...mapState({
            team: (state) => state.team.team,
        }),
        disablingButton: function () {
            const start = new Date(this.startDate + " " + this.startTime);
            const end = new Date(this.endDate + " " + this.endTime);
            return (
                !this.valid ||
                !this.startDate ||
                !this.startTime ||
                !this.endDate ||
                !this.endTime ||
                start > end
            );
        },
    },
    methods: {
        upsertHappening() {
            if (!this.happeningId) {
                this.createHappening();
            } else {
                this.updateHappening();
            }
        },
        async createHappening() {
            this.ajaxPending = true;
            try {
                await this.$store.dispatch("happening/createHappening", {
                    teamId: this.team.id,
                    happening: {
                        name: "test api event name",
                        status: this.status,
                        description: this.description,
                        place: this.place,
                        start_at: this.startDate + " " + this.startTime,
                        end_at: this.endDate + " " + this.endTime,
                    },
                });
                this.ajaxPending = false;
                this.$router.push({
                    name: "happening",
                    params: { id: this.$store.state.happening.happening.id },
                });
            } catch (e) {
                this.dispatchError(e);
                this.ajaxPending = false;
            }
        },
        async updateHappening() {
            this.ajaxPending = true;
            try {
                await this.$store.dispatch("happening/updateHappening", {
                    id: this.happeningId,
                    name: "test api event name",
                    status: this.status,
                    description: this.description,
                    place: this.place,
                    start_at: this.startDate + " " + this.startTime,
                    end_at: this.endDate + " " + this.endTime,
                });
                this.ajaxPending = false;
                this.$emit("updated");
            } catch (e) {
                this.dispatchError(e);
                this.ajaxPending = false;
            }
        },
        dispatchError(e) {
            const event = new CustomEvent("displayMsg", {
                detail: {
                    text: e.response.data.message,
                    color: "error",
                    timeout: 3000,
                },
            });
            document.dispatchEvent(event);
        },
    },
};
</script>

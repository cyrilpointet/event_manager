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

            <div>
                <v-date-picker v-model="startDate" locale="fr" />
                <v-time-picker v-model="startTime" format="24hr" locale="fr" />
            </div>

            <div>
                <v-date-picker v-model="endDate" locale="fr" />
                <v-time-picker v-model="endTime" format="24hr" />
            </div>

            <v-radio-group v-model="status" row>
                <v-radio label="Projet" :value="1"></v-radio>
                <v-radio label="Validé" :value="2"></v-radio>
                <v-radio label="Annulé" :value="3"></v-radio>
            </v-radio-group>

            <v-btn
                color="primary"
                :disabled="disablingButton"
                :loading="ajaxPending"
                @click="createHappening"
            >
                ok
            </v-btn>
        </v-form>
    </div>
</template>

<script>
import { formValidators } from "@/common/services/formValidators";
import { ApiConsumer } from "@/common/services/ApiConsumer";
import { mapState } from "vuex";

export default {
    name: "CreateHappening",
    data: () => {
        return {
            valid: true,
            name: "",
            description: "",
            place: "",
            startDate: new Date().toISOString().substr(0, 10),
            startTime: null,
            endDate: new Date().toISOString().substr(0, 10),
            endTime: null,
            status: 1,
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
        pouet() {
            console.log({
                start_at: this.startDate + " " + this.startTime,
                end_at: this.endDate + " " + this.endTime,
            });
        },
        async createHappening() {
            this.ajaxPending = true;
            try {
                const happening = await ApiConsumer.post(
                    `team/${this.team.id}/happening`,
                    {
                        name: "test api event name",
                        status: 1,
                        description: this.description,
                        place: this.place,
                        start_at: this.startDate + " " + this.startTime,
                        end_at: this.endDate + " " + this.endTime,
                    }
                );
                console.log(happening);
                this.ajaxPending = false;
            } catch (e) {
                console.log(e);
                const event = new CustomEvent("displayMsg", {
                    detail: {
                        text: e.response.data.message,
                        color: "error",
                        timeout: 3000,
                    },
                });
                document.dispatchEvent(event);
                this.ajaxPending = false;
            }
        },
    },
};
</script>

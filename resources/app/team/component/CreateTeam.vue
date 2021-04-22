<template>
    <v-form ref="form" v-model="valid">
        <v-text-field v-model="name" label="Nom" :rules="[rules.required]" />
        <div class="d-flex justify-center">
            <v-btn
                color="primary"
                :disabled="!valid"
                :loading="ajaxPending"
                @click="createTeam"
            >
                Créer
            </v-btn>
        </div>
    </v-form>
</template>

<script>
import { formValidators } from "@/common/services/formValidators";
import { UserTeam } from "@/user/model/UserTeam";

export default {
    name: "CreateTeam",
    data() {
        return {
            valid: true,
            name: "",
            rules: formValidators,
            ajaxPending: false,
        };
    },
    methods: {
        async createTeam() {
            this.ajaxPending = true;
            let newTeam = null;
            try {
                newTeam = await this.$store.dispatch("team/createTeam", {
                    name: this.name,
                });
            } catch (error) {
                this.ajaxPending = false;
                const event = new CustomEvent("displayMsg", {
                    detail: {
                        text: "Oups...",
                        color: "error",
                    },
                });
                document.dispatchEvent(event);
                return;
            }
            this.$store.commit("user/addTeam", UserTeam.fromCreation(newTeam));
            this.ajaxPending = false;
            this.$router.push({ name: "team", params: { id: newTeam.id } });
        },
    },
};
</script>

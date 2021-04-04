<template>
    <div>
        <h3>Créer un groupe</h3>
        <v-form ref="form" v-model="valid">
            <v-text-field
                v-model="name"
                label="Nom"
                :rules="[rules.required]"
            />
            <v-btn
                color="primary"
                :disabled="!valid"
                :loading="ajaxPending"
                @click="createTeam"
            >
                Créer
            </v-btn>
        </v-form>
    </div>
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

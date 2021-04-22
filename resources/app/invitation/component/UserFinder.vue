<template>
    <div>
        <v-form ref="form">
            <v-text-field
                v-model="name"
                label="Nom ou email"
                append-outer-icon="mdi-send"
                @click:append-outer="findUser"
            />
        </v-form>
        <div v-if="users !== null">
            <template v-for="(user, index) in users">
                <v-divider :key="'divider' + user.id" v-if="index !== 0" />
                <v-list-item :key="user.id">
                    <v-list-item-content>
                        <v-list-item-title>
                            {{ user.name }}
                        </v-list-item-title>
                        <v-list-item-subtitle>
                            {{ user.email }}
                        </v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-action>
                        <v-btn icon @click="inviteUser(user)">
                            <v-icon color="primary"> mdi-account </v-icon>
                        </v-btn>
                    </v-list-item-action>
                </v-list-item>
            </template>
            <v-list-item v-if="users.length < 1">
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
import { Invitation } from "@/invitation/model/Invitation";

export default {
    name: "UserFinder",
    data: () => {
        return {
            valid: true,
            name: "",
            ajaxPending: false,
            users: null,
        };
    },
    computed: {
        ...mapState({
            team: (state) => state.team.team,
        }),
    },
    watch: {
        name() {
            this.users = null;
        },
    },
    methods: {
        async findUser() {
            if (this.name !== "") {
                this.users = await ApiConsumer.get("users/" + this.name);
            }
        },
        async inviteUser(member) {
            try {
                const invitation = await ApiConsumer.post(
                    `team/${this.team.id}/invitation`,
                    {
                        user_email: member.email,
                    }
                );
                this.$store.commit(
                    "team/addInvitation",
                    new Invitation(invitation)
                );
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

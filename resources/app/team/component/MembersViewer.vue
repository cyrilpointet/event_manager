<template>
    <div>
        <template v-for="(member, index) in team.members">
            <v-divider :key="'divider' + member.id" v-if="index !== 0" />
            <v-list-item :key="member.id">
                <v-list-item-content>
                    <v-list-item-title
                        >Nom: {{ member.name }}</v-list-item-title
                    >
                    <v-list-item-subtitle>
                        Admin : {{ member.isAdmin ? "oui" : "non" }}
                    </v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-icon v-if="isUserAdmin">
                    <v-icon>mdi-delete</v-icon>
                </v-list-item-icon>
            </v-list-item>
        </template>
    </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";

export default {
    name: "MembersViewer",
    computed: {
        ...mapState({
            team: (state) => state.team.team,
        }),
        ...mapGetters({
            isUserAdmin: "team/isUserAdmin",
        }),
    },
};
</script>

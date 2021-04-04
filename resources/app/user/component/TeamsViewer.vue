<template>
    <v-list>
        <template v-for="(team, index) in user.teams">
            <v-divider :key="'divider' + team.id" v-if="index !== 0" />
            <v-list-item
                :key="team.id"
                @click="$router.push({ name: 'team', params: { id: team.id } })"
            >
                <v-list-item-content>
                    <v-list-item-title>Nom: {{ team.name }}</v-list-item-title>
                    <v-list-item-subtitle>
                        Créé le: {{ team.createdAt }}
                    </v-list-item-subtitle>
                    <v-list-item-subtitle>
                        Admin : {{ team.isAdmin ? "oui" : "non" }}
                    </v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
        </template>
    </v-list>
</template>

<script>
import { mapState } from "vuex";

export default {
    name: "TeamViewer",
    computed: {
        ...mapState({
            user: (state) => state.user.user,
        }),
    },
};
</script>

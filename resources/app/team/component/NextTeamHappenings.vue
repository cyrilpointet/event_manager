<template>
    <v-list dense>
        <template v-for="(happening, index) in happenings">
            <v-divider :key="'divider' + happening.id" v-if="index !== 0" />
            <v-list-item
                :key="happening.id"
                @click="
                    $router.push({
                        name: 'happening',
                        params: { id: happening.id },
                    })
                "
            >
                <v-list-item-content>
                    <v-list-item-title>{{ happening.name }}</v-list-item-title>
                    <v-list-item-subtitle>
                        {{ happening.start }} - {{ happening.status }}
                    </v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-icon class="align-self-center">
                    <v-icon> mdi-chevron-right </v-icon>
                </v-list-item-icon>
            </v-list-item>
        </template>
    </v-list>
</template>

<script>
import { mapState } from "vuex";

export default {
    name: "NextTeamHappenings",
    data: () => {
        return {
            happenings: [],
        };
    },
    computed: {
        ...mapState({
            user: (state) => state.user.user,
            team: (state) => state.team.team,
        }),
    },
    created() {
        this.happenings = this.user.upcomingHappenings.filter((elem) => {
            return elem.team.id === this.team.id;
        });
    },
};
</script>

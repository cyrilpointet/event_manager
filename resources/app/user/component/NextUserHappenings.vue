<template>
    <v-list dense>
        <template v-for="(happening, index) in user.upcomingHappenings">
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
                        {{ happening.team.name }}
                    </v-list-item-subtitle>
                    <v-list-item-subtitle>
                        {{ happening.start }}
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
    name: "NextUserHappenings",
    computed: {
        ...mapState({
            user: (state) => state.user.user,
        }),
    },
};
</script>

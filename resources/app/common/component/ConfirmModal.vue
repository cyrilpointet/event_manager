<template>
    <v-dialog v-model="isOpen" width="500">
        <v-card>
            <v-card-title>
                {{ title }}
            </v-card-title>

            <v-card-text v-if="text">
                {{ text }}
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn text @click="isOpen = false">Annuler</v-btn>
                <v-btn color="error" text @click="doAction">Confirmer</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: "ConfirmModal",
    data: () => {
        return {
            isOpen: false,
            title: "",
            text: "",
            callback: null,
        };
    },
    mounted() {
        document.addEventListener("confirmAction", (evt) => {
            this.text = evt.detail.text;
            this.title = evt.detail.title;
            this.callback = evt.detail.callback;
            this.isOpen = true;
        });
    },
    methods: {
        doAction() {
            this.isOpen = false;
            if (this.callback !== null) {
                this.callback();
            }
        },
    },
};
</script>

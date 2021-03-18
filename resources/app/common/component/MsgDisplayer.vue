<template>
    <v-snackbar v-model="isOpen" :timeout="timeout" :color="color">
        {{ text }}
    </v-snackbar>
</template>

<script>
const SNACKBAR_COLORS = {
    base: "primary-dark",
    error: "error",
};

export default {
    name: "MsgDisplayer",
    data() {
        return {
            isOpen: false,
            text: "",
            color: "",
            timeout: 2000,
        };
    },
    mounted() {
        document.addEventListener("displayMsg", (evt) => {
            this.text = evt.detail.text;
            this.color = evt.detail.color
                ? evt.detail.color
                : SNACKBAR_COLORS.base;
            this.timeout = evt.detail.timeout ? evt.detail.timeout : 2000;
            this.isOpen = true;
        });
    },
};
</script>

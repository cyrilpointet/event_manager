import Vue from "vue";
import Vuelidate from "vuelidate";
import vuetify from "@/theme/vuetify"; // path to vuetify export
import App from "@/App";
import { store } from "@/common/store/store";
import { ApiConsumer } from "@/common/services/ApiConsumer";
import { router } from "@/routes/router";

Vue.use(Vuelidate);

new Vue({
    store,
    router,
    vuetify,
    async beforeCreate() {
        const token = localStorage.getItem("token");
        if (token) {
            ApiConsumer.setToken(token);
            try {
                await this.$store.dispatch("user/getUserWithToken");
                await this.$store.commit("user/setToken", token);
            } catch {
                this.$store.dispatch("user/logout");
                this.$router.push({ name: "account" });
            }
        } else {
            this.$store.dispatch("user/logout");
            this.$router.push({ name: "account" });
        }
    },
    render: (h) => h(App),
}).$mount("#app");

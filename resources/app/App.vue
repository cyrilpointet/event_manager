<template>
    <v-app style="background-color: #f5f5f5">
        <HeaderMobile />

        <div class="container mainView pt-4">
            <router-view />
            <div>
                <div style="height: auto">
                    <v-calendar />
                </div>
            </div>
        </div>
        <MsgDisplayer />
        <ConfirmModal />
    </v-app>
</template>

<script>
import Vue from "vue";
import { mapGetters, mapState } from "vuex";
import MsgDisplayer from "@/common/component/MsgDisplayer";
import ConfirmModal from "@/common/component/ConfirmModal";
import HeaderMobile from "@/common/component/HeaderMobile";

export default Vue.extend({
    name: "app",
    components: { HeaderMobile, MsgDisplayer, ConfirmModal },
    computed: {
        ...mapState({
            user: (state) => state.user.user,
        }),
        ...mapGetters({
            isLogged: "user/isLogged",
        }),
    },
});
</script>

<style lang="scss" scoped>
.link {
    text-decoration: none;
}
</style>

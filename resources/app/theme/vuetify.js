import Vue from "vue";
import Vuetify from "vuetify";
import colors from "vuetify/lib/util/colors";

Vue.use(Vuetify);

const opts = {
    theme: {
        themes: {
            light: {
                primary: colors.orange,
                "primary-dark": colors.orange.darken2,
                error: colors.red.darken2,
            },
        },
    },
};

export default new Vuetify(opts);

import Vue from "vue";
import Vuetify from "vuetify";
import colors from "vuetify/lib/util/colors";

Vue.use(Vuetify);

const opts = {
    theme: {
        themes: {
            light: {
                primary: colors.orange,
                error: colors.red.darken2,
                black: colors.black,
            },
        },
        options: {
            customProperties: true,
        },
    },
};

export default new Vuetify(opts);

import Vue from "vue";
import VueRouter from "vue-router";
import { routes } from "@/routes/routes";

Vue.use(VueRouter);

const router = new VueRouter({ routes });

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        const token = localStorage.getItem("token");
        if (!token) {
            next({
                path: "/account",
                query: { redirect: to.fullPath },
            });
        } else {
            next();
        }
    } else {
        next(); // make sure to always call next()!
    }
});

export { router };

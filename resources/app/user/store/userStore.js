import { ApiConsumer } from "@/common/services/ApiConsumer";
import { User } from "@/user/model/User";
import { UserHappening } from "@/user/model/UserHappening";

export const userStore = {
    namespaced: true,

    state: () => ({
        user: null,
        token: null,
    }),
    getters: {
        isLogged: (state) => {
            return state.user !== null && state.token !== null;
        },
    },
    mutations: {
        setUser(state, value) {
            state.user = value;
        },
        setToken(state, value) {
            state.token = value;
        },
        addTeam(state, value) {
            state.user.teams.push(value);
        },
        removeTeam(state, teamId) {
            const teams = state.user.teams.filter((elem) => elem.id !== teamId);
            state.user.teams = teams;
        },
        upsertHappening(state, happening) {
            const happenings = state.user.upcomingHappenings.filter(
                (elem) => elem.id !== happening.id
            );
            happenings.push(new UserHappening(happening));
            state.user.upcomingHappenings = happenings;
        },
        removeHappening(state, id) {
            const happenings = state.user.upcomingHappenings.filter(
                (elem) => elem.id !== id
            );
            state.user.upcomingHappenings = happenings;
        },
    },
    actions: {
        storeUserAndToken(context, value) {
            const user = new User(value.user);
            context.commit("setUser", user);
            context.commit("setToken", value.token);
            ApiConsumer.setToken(value.token);
            localStorage.setItem("token", value.token);
        },

        createUser(context, values) {
            return new Promise((resolve, reject) => {
                ApiConsumer.post("register", values)
                    .then((data) => {
                        context.dispatch("storeUserAndToken", data);
                        resolve();
                    })
                    .catch((e) => {
                        reject(e);
                    });
            });
        },

        logUser(context, values) {
            return ApiConsumer.post("login", values).then((data) => {
                context.dispatch("storeUserAndToken", data);
            });
        },

        getUserWithToken(context) {
            return new Promise((resolve, reject) => {
                ApiConsumer.get("user")
                    .then((data) => {
                        const user = new User(data);
                        context.commit("setUser", user);
                        resolve();
                    })
                    .catch((e) => {
                        reject(e);
                    });
            });
        },

        logout(context) {
            context.commit("setUser", null);
            context.commit("setToken", null);
            ApiConsumer.removeToken();
            localStorage.removeItem("token");
        },
    },
};

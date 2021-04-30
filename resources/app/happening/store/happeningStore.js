import { ApiConsumer } from "@/common/services/ApiConsumer";
import { Happening } from "@/happening/model/Happening";

export const happeningStore = {
    namespaced: true,

    state: () => ({
        happening: null,
    }),
    mutations: {
        setHappening(state, value) {
            state.happening = value;
        },
    },
    actions: {
        getHappeningById(context, id) {
            return new Promise((resolve, reject) => {
                ApiConsumer.get("happening/" + id)
                    .then((happening) => {
                        const newHappening = new Happening(happening);
                        context.commit("setHappening", newHappening);
                        resolve(newHappening);
                    })
                    .catch((e) => {
                        reject(e);
                    });
            });
        },
        createHappening(context, values) {
            return new Promise((resolve, reject) => {
                ApiConsumer.post(
                    `team/${values.teamId}/happening`,
                    values.happening
                )
                    .then((happening) => {
                        context.commit(
                            "setHappening",
                            new Happening(happening)
                        );
                        resolve(happening);
                    })
                    .catch((e) => {
                        reject(e);
                    });
            });
        },
        updateHappening(context, values) {
            return new Promise((resolve, reject) => {
                ApiConsumer.put(`happening/${values.id}`, values)
                    .then((happening) => {
                        context.commit(
                            "setHappening",
                            new Happening(happening)
                        );
                        resolve(happening);
                    })
                    .catch((e) => {
                        reject(e);
                    });
            });
        },
        deleteHappening(context, id) {
            return new Promise((resolve, reject) => {
                ApiConsumer.delete("happening/" + id, {})
                    .then((resp) => {
                        context.commit("setHappening", null);
                        resolve(resp);
                    })
                    .catch((e) => {
                        reject(e);
                    });
            });
        },
        addMemberToHappening(context, values) {
            return new Promise((resolve, reject) => {
                ApiConsumer.post(`happening/${values.happeningId}/addMember`, {
                    user_id: values.userId,
                })
                    .then((happening) => {
                        const newHappening = new Happening(happening);
                        context.commit("setHappening", newHappening);
                        resolve(newHappening);
                    })
                    .catch((e) => {
                        reject(e);
                    });
            });
        },
        removeMemberFromHappening(context, values) {
            return new Promise((resolve, reject) => {
                ApiConsumer.delete(
                    `happening/${values.happeningId}/removeMember`,
                    {
                        user_id: values.userId,
                    }
                )
                    .then((happening) => {
                        const newHappening = new Happening(happening);
                        context.commit("setHappening", newHappening);
                        resolve(newHappening);
                    })
                    .catch((e) => {
                        reject(e);
                    });
            });
        },
    },
};

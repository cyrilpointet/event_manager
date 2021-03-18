import Home from "@/home/layout/HomePage";
import UserPage from "@/user/layout/UserPage";

export const routes = [
    {
        path: "/",
        name: "home",
        component: Home,
        meta: { requiresAuth: true },
    },
    {
        path: "/account",
        name: "account",
        component: UserPage,
    },
];

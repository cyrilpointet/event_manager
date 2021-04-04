import Home from "@/home/layout/HomePage";
import UserPage from "@/user/layout/UserPage";
import TeamPage from "@/team/layout/TeamPage";

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
    {
        path: "/team/:id",
        name: "team",
        component: TeamPage,
    },
];

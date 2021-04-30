import Home from "@/routes/layout/HomePage";
import UserPage from "@/routes/layout/UserPage";
import TeamPage from "@/routes/layout/TeamPage";
import HappeningPage from "@/routes/layout/HappeningPage";
import TeamsPage from "@/routes/layout/TeamsPage";

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
        path: "/teams",
        name: "teams",
        component: TeamsPage,
    },
    {
        path: "/team/:id",
        name: "team",
        component: TeamPage,
    },
    {
        path: "/happening/:id",
        name: "happening",
        component: HappeningPage,
    },
];

import { UserTeam } from "@/user/model/UserTeam";
import { Invitation } from "@/invitation/model/Invitation";
import { UserHappening } from "@/user/model/UserHappening";

export class User {
    constructor(rawUser) {
        this.id = rawUser.id;
        this.name = rawUser.name;
        this.email = rawUser.email;
        this.created_at = rawUser.created_at;
        this.teams = [];
        rawUser.teams.forEach((team) => {
            this.teams.push(new UserTeam(team));
        });
        this.invitations = [];
        rawUser.invitations.forEach((invitation) => {
            this.invitations.push(new Invitation(invitation));
        });
        this.upcomingHappenings = [];
        rawUser.upcomingHappenings.forEach((happening) => {
            this.upcomingHappenings.push(new UserHappening(happening));
        });
    }

    get createdAt() {
        const createdAt = new Date(this.created_at);
        return createdAt.toLocaleDateString("fr-FR");
    }
}

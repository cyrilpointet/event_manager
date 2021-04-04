import { TeamMember } from "@/team/model/TeamMember";

export class Team {
    constructor(rawTeam) {
        this.id = rawTeam.id;
        this.name = rawTeam.name;
        this.created_at = rawTeam.created_at;
        this.members = [];
        rawTeam.users.forEach((member) => {
            this.members.push(new TeamMember(member));
        });
    }

    get createdAt() {
        const createdAt = new Date(this.created_at);
        return createdAt.toLocaleDateString("fr-FR");
    }
}

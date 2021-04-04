export class UserTeam {
    static fromCreation(newTeam) {
        return new UserTeam({
            id: newTeam.id,
            name: newTeam.name,
            created_at: newTeam.created_at,
            pivot: { admin: 1 },
        });
    }

    constructor(rawTeam) {
        this.id = rawTeam.id;
        this.name = rawTeam.name;
        this.created_at = rawTeam.created_at;
        this.isAdmin = rawTeam.pivot.admin === 1;
    }

    get createdAt() {
        const createdAt = new Date(this.created_at);
        return createdAt.toLocaleDateString("fr-FR");
    }
}

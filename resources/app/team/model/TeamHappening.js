export class TeamHappening {
    constructor(rawHappening) {
        this.id = rawHappening.id;
        this.name = rawHappening.name;
        this.created_at = rawHappening.created_at;
        this.updated_at = rawHappening.updated_at;
        this.description = rawHappening.description;
        this.place = rawHappening.place;
        this.start_at = rawHappening.start_at;
        this.end_at = rawHappening.end_at;
    }

    get createdAt() {
        const createdAt = new Date(this.created_at);
        return createdAt.toLocaleDateString("fr-FR");
    }

    get updatedAt() {
        const createdAt = new Date(this.updated_at);
        return createdAt.toLocaleDateString("fr-FR");
    }

    get start() {
        const createdAt = new Date(this.start_at);
        return createdAt.toLocaleDateString("fr-FR");
    }

    get end() {
        const createdAt = new Date(this.end_at);
        return createdAt.toLocaleDateString("fr-FR");
    }
}

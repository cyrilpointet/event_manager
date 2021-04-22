export class Happening {
    constructor(rawHappening) {
        this.id = rawHappening.id;
        this.name = rawHappening.name;
        this.description = rawHappening.description;
        this.place = rawHappening.place;

        this.created_at = rawHappening.created_at;
        this.updated_at = rawHappening.updated_at;
        this.start_at = rawHappening.start_at;
        this.end_at = rawHappening.end_at;

        this.status_id = rawHappening.status_id;

        this.team = {
            id: rawHappening.team.id,
            name: rawHappening.team.name,
        };
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

    get status() {
        const status = ["projet", "validé", "annulé"];
        return status[this.status_id - 1];
    }
}

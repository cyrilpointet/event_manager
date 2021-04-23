import * as dayjs from "dayjs";

export class Happening {
    constructor(rawHappening) {
        this.id = rawHappening.id;
        this.name = rawHappening.name;
        this.description = rawHappening.description;
        this.place = rawHappening.place;

        this.created_at = rawHappening.created_at;
        this._created_at = dayjs(rawHappening.created_at);
        this.updated_at = rawHappening.updated_at;
        this._updated_at = dayjs(rawHappening.updated_at);
        this.start_at = rawHappening.start_at;
        this._start_at = dayjs(rawHappening.start_at);
        this.end_at = rawHappening.end_at;
        this._end_at = dayjs(rawHappening.end_at);

        this.status_id = rawHappening.status_id;

        this.team = {
            id: rawHappening.team.id,
            name: rawHappening.team.name,
        };
    }

    get createdAt() {
        return this._created_at.format("DD-MM-YYYY");
    }

    get updatedAt() {
        return this._updated_at.format("DD-MM-YYYY");
    }

    get start() {
        return this._start_at.format("DD-MM-YYYY à HH:mm");
    }

    get end() {
        return this._end_at.format("DD-MM-YYYY à HH:mm");
    }

    get status() {
        const status = ["projet", "validé", "annulé"];
        return status[this.status_id - 1];
    }
}

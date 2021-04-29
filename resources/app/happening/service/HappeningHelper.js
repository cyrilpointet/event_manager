export class HappeningHelper {
    static get presenceTextValues() {
        return ["non-renseigné", "présent", "absent", "ne sait pas"];
    }

    static get presenceIconValues() {
        return [
            "mdi-account-cog",
            "mdi-account-check",
            "mdi-account-cancel",
            "mdi-account-question",
        ];
    }

    static getPresenceText(presence) {
        return this.presenceTextValues[presence];
    }

    static getPresenceIcon(presence) {
        return this.presenceIconValues[presence];
    }

    static get getSelectItems() {
        const items = [];
        for (let i = 0; i < this.presenceTextValues.length; i++) {
            items.push({
                value: i,
                text: this.presenceTextValues[i],
            });
        }
        return items;
    }
}

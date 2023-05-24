export class SessionService {
    constructor() {
        this.sessionData = {};
    }

    setSessionData(data) {
        this.sessionData = { ...data };
    }

    getSessionData() {
        return this.sessionData;
    }

    updateSessionData(updatedData) {
        this.sessionData = { ...this.sessionData, ...updatedData };
    }
}

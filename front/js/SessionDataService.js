class SessionDataService {
    constructor() {
        if (!SessionDataService.instance) {
            SessionDataService.instance = this;
        }
        return SessionDataService.instance;
    }

    setSessionData(data) {
        sessionStorage.setItem('sessionData', JSON.stringify(data));
    }

    getSessionData() {
        const sessionData = sessionStorage.getItem('sessionData');
        return sessionData ? JSON.parse(sessionData) : null;
    }

    updateSessionData(updatedData) {
        const currentData = this.getSessionData();
        const newData = { ...currentData, ...updatedData };
        this.setSessionData(newData);
    }

    deleteSessionData() {
        sessionStorage.removeItem('sessionData');
        this.setSessionData(null);
    }
}

const sessionDataService = new SessionDataService();
export default sessionDataService;
class AppStorage {
    storageToken(token) {
        localStorage.setItem('token', token);
    }

    storeUser(user) {
        localStorage.setItem('user', user);
    }

    store(token, user) {
        this.storageToken(token);
        this.storeUser(user);
    }

    clear() {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
    }

    getToken() {
        localStorage.getItem(token);
    }

    getUser() {
        localStorage.getItem(user);
    }
}

export default AppStorage = new AppStorage();
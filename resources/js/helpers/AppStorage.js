class AppStorage {
    storageToken(token) {
        localStorage.setItem('token', token);
    }

    storeUser(user) {
        localStorage.setItem('user', user);
    }

    storeEmail(email) {
        localStorage.setItem('email', email);
    }

    store(token, user, email) {
        this.storageToken(token);
        this.storeUser(user);
        this.storeEmail(email);
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
function logout() {
    // Clear the saved user token
    localStorage.removeItem('userToken');
    sessionStorage.clear();

    // Redirect to login page
    window.location.href = '/login';
}
export const getLocalAuth = () => {
    const auth = localStorage.getItem("auth_token");
    return auth ? auth : "";
};

export const setLocalAuth = (value) => {
    localStorage.setItem("auth_token", JSON.stringify(value));
};

export const removeLocalAuth = () => {
    localStorage.removeItem("auth_token");
};

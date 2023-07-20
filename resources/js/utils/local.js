export const getLocalAuth = () => {
    const auth = localStorage.getItem("auth_data");
    return auth ? auth : "";
};

export const setLocalAuth = (value) => {
    localStorage.setItem("auth_data", JSON.stringify(value));
};

export const removeLocalAuth = () => {
    localStorage.removeItem("auth_data");
};

export const isEmail = (string) => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (string && emailRegex.test(string)) {
        return true;
    }
    return false;
};

export const convertUndefinedToString = (value) => {
    if (typeof value === "undefined" ) {
        return "";
    }
    return value;
};

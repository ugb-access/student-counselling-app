import api from "@/config/api";
import { getLocalAuth } from "@/utils/local";
import { isEmail } from "@/utils/string";

export const checkUserAuth = () => {
    const auth_data = getLocalAuth();
   
    if (auth_data) {
        return api({
            method: "get",
            url: "/user",
            headers: {
                Authorization: `Bearer ${JSON.parse(auth_data).token}`,
            },
        });
    } else {
        return false;
    }
};

export const loginUser = ({ identifier, password }) => {
    let data = {
        username: identifier,
        password,
    };

    if (isEmail(identifier)) {
        data.username = undefined;
        data.email = identifier;
    }
    return api({
        method: "Post",
        url: "/login",
        data,
    });
};

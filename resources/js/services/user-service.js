import api from "@/config/api";
import { getLocalAuth } from "@/utils/local";
import axios from "axios";

export const getAllAdmins = () => {
    const auth_token = getLocalAuth();

    return api({
        method: "get",
        url: "/admin/list",
        headers: {
            Authorization: `Bearer ${JSON.parse(auth_token)}`,
        },
    });
};

export const getAllCounsellor = () => {
    const auth_token = getLocalAuth();

    return api({
        method: "get",
        url: "/counsellor/list",
        headers: {
            Authorization: `Bearer ${JSON.parse(auth_token)}`,
        },
    });
};

export const getAllStudents = () => {
    const auth_token = getLocalAuth();

    return api({
        method: "get",
        url: "/student/list",
        headers: {
            Authorization: `Bearer ${JSON.parse(auth_token)}`,
        },
    });
};

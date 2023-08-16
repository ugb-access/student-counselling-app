import axios from "axios";

const instance = axios.create({
    baseURL: import.meta.env.PROD
        ? "http://13.42.226.161/api"
        : "http://localhost:8000/api",
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
    },
});



export default instance;

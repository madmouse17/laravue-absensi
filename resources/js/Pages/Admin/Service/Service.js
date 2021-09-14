import axios from "axios";

export default class UserService {
    getUser() {
        return axios.get("/admin/user/json").then((res) => res.data.data);
    }
    getPosition() {
        return axios.get("/admin/position/json").then((res) => res.data.data);
    }
}
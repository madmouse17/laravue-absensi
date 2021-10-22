import axios from "axios";

export default class UserService {
    getUser() {
        return axios.get("/admin/user/json").then((res) => res.data.data);
    }
    getPosition() {
        return axios.get("/admin/position/json").then((res) => res.data.data);
    }
    getEmploye() {
        return axios.get("/admin/employe/json").then((res) => res.data.data);
    }
    getAbsensi() {
        return axios.get("/employe/absensi/json").then((res) => res.data.data);
    }
}
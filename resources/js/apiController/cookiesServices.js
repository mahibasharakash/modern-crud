import Cookies from "js-cookie";

const cookieService = {
    set(name, value, days = 30) {
        Cookies.set(name, value, { expires: days, path: "/" });
    },

    get(name) {
        return Cookies.get(name) || null;
    },

    remove(name) {
        Cookies.remove(name, { path: "/" });
    }
};

export default cookieService;

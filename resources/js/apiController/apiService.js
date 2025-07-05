import cookiesServices from "../apiController/cookiesServices.js";

const apiService = {

    headerContent: {
        'Content-Type': 'application/json; charset=utf-8',
    },

    mediaHeaderContent: {
        'Content-Type': 'multipart/form-data',
    },

    authHeaderContent: () => ({
        'Content-Type': 'application/json; charset=utf-8',
        'Authorization': `Bearer ${cookiesServices.get('auth_token') || ''}`
    }),

    authHeaderMediaContent: () => ({
        'Content-Type': 'multipart/form-data',
        'Authorization': `Bearer ${cookiesServices.get('auth_token') || ''}`
    })

}

export default apiService;

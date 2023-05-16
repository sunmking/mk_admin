import {defineStore} from 'pinia'
import {getUserToken} from "../api/token";

export const useStore = defineStore('main', {
    state: () => ({
            userToken:''
    }),
    getters: {
        getUserToken(state) {
            return state.userToken;
        },
    },
    actions:{
        refreshToken(id) {
            getUserToken({uid:id}).then((resp) => {
               this.userToken =  resp.Data.token;
                localStorage.setItem('user_token',resp.Data.token)
            }).catch((err) => {
                console.log(err);
            });
        }
    }
})
import Axios from 'axios'
import {get, post} from '../../helper/request'
const types = {
  LOGOUT: 'LOGOUT',
  SAVE_TOKEN: 'SAVE_TOKEN',
  FETCH_USER: 'FETCH_USER',
  FETCH_USER_SUCCESS: 'FETCH_USER_SUCCESS',
  FETCH_USER_FAILURE: 'FETCH_USER_FAILURE'
};

const emptyUser = {
  id: null,
  about_me: null,
  address: null,
  avatar: null,
  birthday: null,
  email: null,
  facebook_url: null,
  favorite_quote: null,
  gender: null,
  japanese_certificate: null,
  japanese_level: null,
  job: null,
  name: null,
  phone_number: null,
  is_teacher: null
};

const auth = {
  state: {
    user: emptyUser,
    token: window.localStorage.getItem('token') ? window.localStorage.getItem('token') : null
  },
  mutations: {
    [types.SAVE_TOKEN](state, {token}) {
      state.token = token;
      window.localStorage.setItem('token', token);
    },
    [types.FETCH_USER_SUCCESS](state, {user}) {
      state.user = user;
      if(state.user.avatar) {
        state.user.avatar = state.user.avatar
      }
    },
    [types.FETCH_USER_FAILURE](state) {
      state.token = null;
    },
    [types.LOGOUT](state) {
      state.user = emptyUser;
      state.token = null;
      window.localStorage.removeItem('token');
    }
  },
  actions: {
    saveToken({commit}, {token}) {
      commit(types.SAVE_TOKEN, {token});
    },

    fetchUser({commit, state}) {
      return new Promise((resolve, reject) => {
        get(`/api/user/auth/me`)
          .then(({data}) => {
            commit(types.FETCH_USER_SUCCESS, {user: data});
            resolve();
          })
          .catch(() => {
            commit(types.FETCH_USER_FAILURE);
            reject();
          });
      });

    },

    logout({commit, state}) {
      return new Promise((resolve, reject) => {
        post(`/api/user/auth/logout`)
          .then(() => {
            commit(types.LOGOUT);
            resolve();
          })
          .catch(() => {
            reject();
          })
      });
    }
  },
  namespaced: true,
};

export default auth;

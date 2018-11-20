import Vue from 'vue'
import Vuex from 'vuex'
import auth from './modules/auth.js'
import modals from './modals.js'

Vue.use(Vuex);

const store = new Vuex.Store({
  modules : {
    auth,
  },
  state: {
    isLogin: false,
    accessKey: null,
    user: null,
    notification: null,
    modals: modals,
    comments: {
      likes: [],
    },

    bookmarks: {
      comments: [],
    },
    moderatingAt: [],
  },

  getters: {},
  mutations: {
    resetData(state) {
      state.isLogin = false;
      state.accessKey = null;
      state.user = null;
      state.notification = null;
      state.comments.likes = [];
      state.bookmarks.comments = [];
      state.moderatingAt = [];
    },
  },
  actions: {},
});

export default store;

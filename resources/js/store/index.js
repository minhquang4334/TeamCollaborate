import Vue from 'vue'
import Vuex from 'vuex'
import Auth from './modules/auth'

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    isLogin: false,
    accessKey: null,
    user: null,
    notification: null,
    role: null,
    cam_paginate: 1,
    cam_listCampaign: [],
    kpi_listKPI: [],
    kpi_paginate: 1,
    accountId: null,
    settingPrefs: {},
    emailContract: null,
    emailInviteCustomer: null
  },

  getters: {},
  mutations: {
    resetData(state) {
      state.isLogin = false;
      state.accessKey = null;
      state.user = null;
      state.notification = null;
      state.role = null;
      state.cam_paginate = 1;
      state.cam_listCampaign = [];
      state.kpi_listKPI = [];
      state.kpi_paginate = 1;
      state.settingPrefs = {};
    },
    modules : {
      Auth
    }
  },
  actions: {},
});

export default store;

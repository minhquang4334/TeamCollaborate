import Vue from 'vue'
import Vuex from 'vuex'

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
    resetAccountId(state) {
      state.accountId = null;
    },
    resetEmailContract(state) {
      state.emailContract = null;
    },
    resetEmailInviteCustomer(state) {
      state.emailInviteCustomer = null;
    },
    loginSuccess(state, token) {
      state.isLogin = true;
      state.accessKey = token;
    },

    getUserInfo(state, user) {
      state.user = user;
      state.role = user.role_id;
    },
    getUserNotification(state, notification) {
      state.notification = notification;
    },
    getUsersSelectize(state, usersselectize) {
      state.users_selectize = usersselectize;
    },
    //SET NUMBER OF PAGE
    setNumberOfPageCampaign(state, data) {
      state.cam_paginate = data;
    },
    //GET DATA FOR LIST CAMPAIGN
    getDataListCampaign(state, data) {
      state.cam_listCampaign = data;
    },
    //GET DATA FOR LIST KPI
    getDataListKPI(state, data) {
      state.kpi_listKPI = data;
    },
    // SET NUMBER OF PAGE
    setNumberOfPageKPI(state, data) {
      state.kpi_paginate = data;
    },
    //Set Preference
    setPreferenceEmailNotification(state, data) {
      state.settingPrefs = data;
    },
    //set account id for add order page
    setAccountIdForAddOrder(state, data) {
      state.accountId = data
    },
    //Set Preference
    setPreferenceEmailNotification(state, data) {
      state.settingPrefs = data;
    },
    //set contract detail for send email page
    setEmailContract(state, data) {
      state.emailContract = data;
    },
    //set customer detail for send email page
    setEmailInviteCustomer(state, data) {
      state.emailInviteCustomer = data;
    }
  },
  actions: {},
});

export default store;

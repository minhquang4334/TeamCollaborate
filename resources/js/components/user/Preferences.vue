<template>
    <el-dialog title="Preferences"
               @close="close"
               :visible="true"
               append-to-body
               fullscreen
               class="user-select">
        <div class="padding-bottom-10 flex1 user-select"
             id="settings">
            <div class="left-sidebar-box">
                <div class="side-tabs">
                    <a :to="{ name: 'user-settings-account' }"
                       href="#"
                       @click.prevent="changeRoute('account')"
                       :class="{'is-active': route === 'account'}">
                        My Account
                    </a>

                    <a :to="{ name: 'user-settings-profile' }"
                       href="#"
                       @click.prevent="changeRoute('profile')"
                       :class="{'is-active': route === 'profile'}">
                        My Profile
                    </a>

                    <a :to="{ name: 'user-settings-email-and-password' }"
                       href="#"
                       @click.prevent="changeRoute('email-and-password')"
                       :class="{'is-active': route === 'email-and-password'}">
                        Email & Password
                    </a>

                    <hr>

                    <a :to="{ name: 'user-settings-delete-account' }"
                       href="#"
                       @click.prevent="changeRoute('delete-account')"
                       :class="{'is-active': route === 'delete-account'}"
                       class="go-red">
                        Delete Account
                    </a>
                </div>

                <div class="content flex1">
                    <transition name="slide-fade"
                                mode="out-in">
                        <component :is="currentView"></component>
                    </transition>
                </div>
            </div>
        </div>
    </el-dialog>
</template>

<script>
  import UserSettingsEditAccount from '../user/UserSettingsEditAccount.vue';
  import UserSettingsEditProfile from '../user/UserSettingsEditProfile.vue';
  import UserSettingsDeleteAccount from '../user/UserSettingsDeleteAccount.vue';
  import UserSettingsEditEmailAndPassword from '../user/UserSettingsEditEmailAndPassword.vue';

  export default {
    // props: ['visible'],

    components: {
      UserSettingsEditAccount,
      UserSettingsEditProfile,
      UserSettingsDeleteAccount,
      UserSettingsEditEmailAndPassword
    },

    data() {
      return {
        route: 'profile'
      };
    },

    beforeDestroy() {
      if (window.location.hash == '#preferences') {
        history.go(-1);
      }
    },

    created() {
      window.location.hash = 'preferences';
    },

    computed: {
      currentView() {
        switch (this.route) {
          case 'profile':
            return 'UserSettingsEditProfile';
            break;

          case 'email-and-password':
            return 'UserSettingsEditEmailAndPassword';
            break;

          case 'delete-account':
            return 'UserSettingsDeleteAccount';
            break;

          default:
            // 'account'
            return 'UserSettingsEditAccount';
            break;
        }
      }
    },

    methods: {
      close() {
        this.$router.push({
          name: 'homeIndex'
        })
      },

      changeRoute(route) {
        this.route = route;
      },
    }
  };
</script>

<style lang="scss">
    .go-red.is-active {
        background: #db6e6e !important;
        color: #fff;
    }
</style>

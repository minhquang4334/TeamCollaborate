import store from '../../store'

export default function (to, from, next) {
  if (!store.state.auth.token) {
    next({name: 'login'});
  }
  else {
    store.dispatch('auth/fetchUser')
      .then(() => {
        next();
      })
      .catch(() => {
        next({name: 'login'})
      });
  }

};
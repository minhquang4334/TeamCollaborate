import store from '../../store'

export default function (to, from, next) {
  if (!store.state.auth.token) {
    next();
  }
  else {
    if(!store.state.auth.user.id){
      store.dispatch('auth/fetchUser')
        .then(() => {
          next({name: 'homeIndex'});
        })
        .catch(() => {
          next()
        });
    } else {
      next({name: 'homeIndex'});
    }
  }
};
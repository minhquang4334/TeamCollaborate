import axios from 'axios'
import store from '../store'

export function get(url) {
  return axios({
    method: 'GET',
    url: process.env.HOST + url,
    headers: {
      'X-Authorization': "Bearer " + store.state.accessKey,
    },
    withCredentials: false,
  })
}

export function post_for_login(url, payload) {
  return axios({
    method: 'POST',
    data: payload,
    url: process.env.HOST + url,
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
    },
    withCredentials: false,
  })
}

export function post(url, payload) {
  return axios({
    method: 'POST',
    url: process.env.HOST + url,
    data: payload,
    headers: {
      'Content-Type': 'application/json',
      'X-Authorization': "Bearer " + store.state.accessKey,
    },
    withCredentials: false,
  })
}

export function patch(url, payload) {
  return axios({
    method: 'PATCH',
    url: url,
    data: payload
  })
}

export function put(url, payload) {
  return axios({
    method: 'PUT',
    url: process.env.HOST + url,
    data: payload,
    headers: {
      'Content-Type': 'application/json',
      'X-Authorization': "Bearer " + store.state.accessKey,
    },
  })
}
export function del(url) {
  return axios({
    method: 'DELETE',
    url: process.env.HOST + url,
    headers: {
      'X-Authorization': "Bearer " + store.state.accessKey,
      'Content-Type': 'application/json',
    },
    withCredentials: false,
  })
}

export function XMLpost(url, formData){
  return new Promise((resolve, reject) => {
    let client = new XMLHttpRequest();
    client.open('POST', process.env.HOST + url, true);

    client.onreadystatechange = function () {
      if (this.readyState !== 4) {
        return;
      }
      if (this.status === 200 || this.status === 201) {
        resolve(this); // data = this.responseText
      } else {
        reject(this); // data = this.responseText
      }
    };
    client.setRequestHeader('X-Authorization', 'Bearer ' + store.state.accessKey);
    client.send(formData);
  });
}

export function interceptors(cb) {
  axios.interceptors.response.use((res) => {
    return res;
  }, (err) => {
    cb(err);
    return Promise.reject(err)
  })
}
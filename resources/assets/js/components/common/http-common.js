import axios from 'axios';
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
export const HTTP = axios.create({
  baseURL: 'http://laraveltest.com/cvmanagerapi/'
})
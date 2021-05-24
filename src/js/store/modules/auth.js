import jsonToForm from '../../utilities/json-to-form';

export default {
  namespaced: true,
  state: {
  },
  mutations: { 
  },
  actions: {      
    login({commit, state}, userLogin) {

      let formData = jsonToForm(userLogin);

      return axios.post(`/api/login/`, formData)
        .then((res) => {
          return res.data;
        });      
    },
    register({commit, state}, userRegister) {

      let formData = jsonToForm(userRegister);

      return axios.post(`/api/register/`, formData)
        .then((res) => {
          return res.data;
        });      
    }         
  }
};
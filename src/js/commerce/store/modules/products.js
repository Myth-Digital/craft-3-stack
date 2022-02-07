export default {
  namespaced: true,
  state: {
  },
  mutations: { 
  },
  actions: {
    searchProducts({commit, state}, searchQuery) {

      let endpointUrl = `/api/product/search?take=50&skip=0&query=${searchQuery}`;

      return axios.get(endpointUrl)
        .then((res) => {
          return res.data;
        });
    },          
  }
};
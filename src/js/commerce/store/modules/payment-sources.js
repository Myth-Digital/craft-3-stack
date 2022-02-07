export default {
  namespaced: true,
  state: {
    paymentSources: []
  },
  mutations: {
    SET_PAYMENT_SOURCES(state, payload) {
      state.paymentSources = payload;
    },  
    ADD_PAYMENT_SOURCE(state, payload) {
      state.paymentSources.push(payload);
    },      
  },
  actions: {
    tokenizeCard({}, {card, apiEndpoint}) {

      let storePromise = new Promise((resolve, reject) => {

        let url = `${apiEndpoint}?publishableId=${card.publishableId}&pan=${card.pan}&cvv=${encodeURIComponent(card.cvv)}&callback=tokenizationCallback&v=${(new Date()).getTime()}`;

        var head = document.getElementsByTagName("head")[0];
        var script = document.createElement("script");
  
        script.id = "PPNETJSONP";
        script.charset = 'utf-8';
        script.src = url;
  
        let cleanupCallback = function() {
          var script;
          while (script = document.getElementById('PPNETJSONP')) {
              script.parentNode.removeChild(script);
              for (var prop in script) {
                  try {
                      delete script[prop];
                  } catch (e) {}
              }
          }
        }
  
        let timeoutId = setTimeout(function() {
  
          cleanupCallback();
          reject('Timeout exceeded');
  
        }, 5000);

        let respCallback = function(res) {
          clearTimeout(timeoutId);
          resolve(res);
        };

        window.tokenizationCallback = respCallback;
        
        head.appendChild(script);  

      });

      return storePromise;
    },
    getPaymentSources({commit}) {
      return axios.get(`/api/payment-source`)
        .then((res) => {
          commit('SET_PAYMENT_SOURCES', res.data);
          return res.data;
        });      
    },  
    addPaymentSource({commit}, payload) {

      return axios.post(`/api/payment-source/add`, payload)
        .then((res) => {
          commit('ADD_PAYMENT_SOURCE', res.data);
          return res.data;
        });      
    }
  }
};
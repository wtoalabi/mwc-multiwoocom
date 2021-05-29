// src/plugins/vuetify.js
import "../../scss/fonts/mdi.css"
import Vue from 'vue'
import Vuetify from 'vuetify/lib'

Vue.use(Vuetify);

const opts = {
  theme: {
    themes: {
      light: {
        primary: '#0097A7',
        secondary: '#b0bec5',
        accent: '#4DB6AC',
        error: '#b71c1c',
      },
    },
  },
  icons: {
    iconfont: 'mdi', // 'mdi' || 'mdiSvg' || 'md' || 'fa' || 'fa4' || 'faSvg'
  },
};

export default new Vuetify(opts)


/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */
require('../../../node_modules/jquery-ui-bundle/jquery-ui.min.js');
require('./bootstrap');

import vuei18n from 'vue-i18n';
import Locales from './vue-i18n-locales.generated.js';

Vue.use(vuei18n);
Vue.config.lang=Laravel.lang;
Vue.i18n = new vuei18n({
    locale: Laravel.lang,
    fallbackLocale: 'en',
    messages: Locales
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

Vue.component(
    'importer',
    require('./components/importer/importer.vue')
);

// Commented out currently to avoid trying to load vue everywhere.
// const app = new Vue({
//     el: '#app'
// });

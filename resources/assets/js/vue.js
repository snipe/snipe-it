
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import PassportClients from './components/passport/Clients.vue'
import PassportAuthorizedClients from './components/passport/AuthorizedClients.vue'
import PassportPersonalAccessTokens from './components/passport/PersonalAccessTokens.vue'
import Importer from './components/importer/importer.vue'
import FieldsetDefaultValues from './components/forms/asset-models/fieldset-default-values.vue'

Vue.component(
    'passport-clients',
    PassportClients
);

Vue.component(
    'passport-authorized-clients',
    PassportAuthorizedClients
);

Vue.component(
    'passport-personal-access-tokens',
    PassportPersonalAccessTokens
);

Vue.component(
    'importer',
    Importer
);

Vue.component(
    'fieldset-default-values',
    FieldsetDefaultValues
);

// Commented out currently to avoid trying to load vue everywhere.
// const app = new Vue({
//     el: '#app'
// });

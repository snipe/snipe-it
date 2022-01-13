
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
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

// This component has been removed and replaced with a Livewire implementation
// Vue.component(
//     'importer',
//     require('./components/importer/importer.vue').default
// );

// This component has been removed and replaced with a Livewire implementation
// Vue.component(
//     'fieldset-default-values',
//     require('./components/forms/asset-models/fieldset-default-values.vue').default
// );

// Commented out currently to avoid trying to load vue everywhere.
// const app = new Vue({
//     el: '#app'
// });

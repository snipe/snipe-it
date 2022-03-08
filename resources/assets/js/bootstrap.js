window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
//window.$ = window.jQuery = require('jquery');

/**
 * jQuery UI is loaded here and then the tooltip is assigned another funtion name
 * This resolves the issue of jquery-ui & bootstrap tooltip conflict
 */
require('jquery-ui');
jQuery.fn.uitooltip = jQuery.fn.tooltip; 

/**
 * Load boostrap
 */
require('bootstrap-less');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = require('vue').default;
window.eventHub = new Vue();
require('vue-resource');

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

Vue.http.interceptors.push(function (request, next) {
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);

    next();
});

// require('admin-lte');

// require('chart.js');

// require('jquery-form-validator'); //says something about dependency
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });



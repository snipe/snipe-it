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



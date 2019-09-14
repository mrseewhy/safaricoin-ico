
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../bootstrap');
require('../plugins');
require('./plugins/agency');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('deposit-addresses', require('./components/DepositAddresses.vue'));
Vue.component('transactions', require('./components/Transactions.vue'));
Vue.component('withdraw', require('./components/Withdraw.vue'));

import Countdown from 'vuejs-countdown';
export default {
    components: { Countdown }
}
Vue.component('countdown', Countdown);

Vue.config.ignoredElements = [
    'canvas'
]

const app = new Vue({
    el: '#app'
});

window.app = app;

require('./plugins/particles');

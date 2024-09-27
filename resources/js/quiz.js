window._ = require('lodash');
/*try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}*/
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// require('./bootstrap');
window.Vue = require('vue');
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

Vue.prototype.trans = (key) => {
    return _.get(window.trans, key, key);
};

Vue.component('quiz-main', require('./components/quiz/quiz_main').default);
const quiz = new Vue({
    el: '#quiz',

});

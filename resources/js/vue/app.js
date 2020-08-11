const Vue = require('vue');

Vue.component('calendar-table', require('./components/CalendarTable.vue').default);

new Vue({el: '#vue-app'});

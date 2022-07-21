/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('chat-messages', require('./components/ChatMessages.vue').default);
Vue.component('chat-form', require('./components/ChatForm.vue').default);
Vue.use(require('vue-moment'));
Vue.use(require('vue-cookie'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import 'fa-icons';

const app = new Vue({
    el: '#app',
    data: {
        messages: [],
        colors: [],
        hidden: false,
        wide: false,
        name: '',
        start: true,
    },
    computed: {
        getName() {
            if (this.$refs.form && this.$refs.form.name) {
                return this.$refs.form.name
            }

            return '&nbsp;';
        }
    },
    created() {
        this.fetchMessages();
        this.update();

        window.Echo.channel('chat')
            .listen('MessageSent', (e) => {
                this.messages.push({
                    message: e.message.message,
                    author: e.user
                });
            })
            .listen('MessageDelete', (e) => {
                this.cleanMessages(e);
            });
    },
    methods: {
        groupMessages() {
            self = this;
            self.lastMessage = {author: {name: null}};
            self.date = Vue.moment();

            this.messages.forEach((message) => {
                if (self.date.diff(message.created_at, 'days')) {
                    message.date = true;
                }

                message.group = false;

                if (self.lastMessage.author.name == message.author.name) {
                    message.group = true;
                }

                self.lastMessage = message;
            });
            this.scroll();
        },
        scroll() {
            var x = 0;
            var intervalID = setInterval(function () {

                var elem = document.getElementById('scroll');
                elem.scrollTop = elem.scrollHeight;

                if (++x === 5) {
                    window.clearInterval(intervalID);
                }
            }, 100);
        },
        fetchMessages() {
            axios.get('/messages').then(response => {
                this.messages = response.data;
                this.groupMessages();

            });
        },
        addMessage(message) {
            self = this;
            message.hash = this.$cookie.get("hash");
            self.message = message;
            axios.post('/messages', message).then(response => {
                if (!response.data.status) {
                    return false;
                }

                if (response.data.hash) {
                    this.$cookie.set("hash", response.data.hash, { expires: '1Y' });
                }

                self.message.author.color = response.data.color;
                self.messages.push(self.message);
                console.log(response.data);
                this.groupMessages();
            });
        },
        cleanMessages(message) {
            function clean(id) {
                return function(element) {
                    return id != element.id;
                }
            }

            this.messages = this.messages.filter(clean(message.id));
        },
        deleteMessage(message) {
            this.cleanMessages(message)
            axios.delete('/messages/' + message.id).then(response => {
                console.log(response.data);
            });
        },
        open() {
            this.hidden = false;
            window.top.postMessage('open', '*')
        },
        close() {
            window.top.postMessage('closed', '*')
        },
        hideChat() {
            this.hidden = true;
            window.top.postMessage('only-button', '*')
        },
        expand() {
            this.wide = !this.wide;
            window.top.postMessage(this.wide ? 'expanded' : 'open', '*')
        },
        restart(){
            this.$refs.form.restart();
        },
        update() {
            var self = this;

            setTimeout(() => {
                self.name = self.$refs.form.name;
            }, 100)
        },
    }
});

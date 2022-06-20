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
    },
    created() {
        this.fetchMessages();

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
            self.date = message.created_at

            this.messages.forEach((message) => {
                message.date
                message.group = false;

                if (self.lastMessage.author.name == message.author.name) {
                    message.group = true;
                }

                self.lastMessage = message;
            })
        },
        fetchMessages() {
            axios.get('/messages').then(response => {
                this.messages = response.data;
                this.groupMessages();
            });
        },
        addMessage(message) {
            self = this;
            self.message = message;
            axios.post('/messages', message).then(response => {
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
        }
    }
});

<template>
    <div class="input-group">
        <div class="w-100">
            <div v-if="start">
        <input
            type="text"
            name="name"
            class="form-control input-sm d-inline-block bg-white bg-opacity-50"
            placeholder="username"
            style="width: 50%"
            v-model="name"

        />

            <button class="btn btn-dark btn-lg bg-opacity-10" id="btn-start" @click="setUsername">
                start
            </button>
                <div v-if="nameAlert" class="text-danger" style="margin-top: -0.6em">Имя не доступно</div>
            </div>
            <div v-else>
        <input
            id="btn-input"
            type="text"
            name="message"
            class="form-control input-sm mt-1 bg-white d-inline-block bg-opacity-50"
            style="width: 80%"
            placeholder="Type your message here..."
            v-model="newMessage"
        @keyup.enter="sendMessage"
        />
                <span v-if="showAlert" class="text-danger">wait... </span>
            <span class="input-group-btn d-inline-block" v-else>
            <button class="btn btn-dark btn-lg bg-opacity-10" id="btn-chat" @click="sendMessage" :disabled="!canSend">
                <i class="fa fa-paper-plane" aria-hidden="true"></i>
            </button>
                </span>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    data() {
        return {
            newMessage: "",
            name: "",
            timestamp: 0,
            msgCount: 0,
            showAlert: false,
            nameAlert: false,
            start: true
        };
    },
    watch: {
        name: function (val) {
            this.nameAlert = false;
        },
    },
    computed: {
        canSend() {
            if (!this.name.length) {
                return false;
            } else if (!this.newMessage.length) {
                return false;
            } else if (this.showAlert) {
                return false;
            }

            return true;
        }
    },
    created() {
        if (this.$cookie.get('name')) {
            this.name = this.$cookie.get('name');
            this.start = false;
        }
    },
    methods: {
        sendMessage() {
            if (!this.canSend) {
                return null;
            }

            var newTimestamp = Date.now() / 10000 | 0;

            if (newTimestamp == this.timestamp) {
                if (this.msgCount >= 1) {
                    this.timestamp = newTimestamp + 1
                    this.showAlert = true;
                    var pause = (newTimestamp + 2) * 10000 - Date.now()
                    setTimeout(() => {
                        this.showAlert = false;
                        this.msgCount = 0;
                    }, pause)

                    return null;
                }

                this.msgCount++;
            }

            this.timestamp = newTimestamp;

            this.$emit("messagesent", {
                sender: this.name,
                author: {name: this.name},
                created_at: Vue.moment(),
                message: this.newMessage,
            });

            this.newMessage = "";
        },
        setUsername() {
            let data = {
                name: this.name,
                hash: this.$cookie.get("hash")
            }

            axios.post('/author/check', data).then(response => {
                if (!response.data.status) {
                    this.nameAlert = true;

                    return false;
                }

                this.$cookie.set("name", this.name, { expires: '1Y' });
                this.start = false;
                this.$parent.update();
            });
        },
        restart() {
            let data = {
                name: this.name,
                hash: this.$cookie.get("hash")
            }

            axios.post('/author/delete', data).then(response => {
                this.$parent.fetchMessages();
            });

            this.nameAlert = false;
            this.$cookie.delete("name");
            this.start = true;
        },
    },

};
</script>

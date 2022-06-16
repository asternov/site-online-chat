<template>
    <div class="input-group">
        <div class="w-100">
        <input
            type="text"
            name="name"
            class="form-control input-sm d-inline-block bg-white bg-opacity-50"
            placeholder="username"
            style="width: 50%"
            v-model="name"
        />
      <span v-if="showAlert" class="text-danger">wait... </span>


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
            <span class="input-group-btn d-inline-block">
            <button class="btn btn-dark btn-lg bg-opacity-10" id="btn-chat" @click="sendMessage" :disabled="!canSend">
                <i class="fa fa-paper-plane" aria-hidden="true"></i>
            </button>
                </span>
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
        };
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
                message: this.newMessage,
            });

            this.newMessage = "";
        }
    },
};
</script>

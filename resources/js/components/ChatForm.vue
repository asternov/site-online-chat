<template>
    <div class="input-group">
        <div class="w-100">
        <input
            type="text"
            name="name"
            class="form-control input-sm d-inline-block"
            placeholder="username"
            style="width: 50%"
            v-model="name"
        />
            <span class="input-group-btn d-inline-block">
      <button class="btn btn-primary btn-sm" id="btn-chat" @click="sendMessage">
        Send
      </button>
    </span>
        <input
            id="btn-input"
            type="text"
            name="message"
            class="form-control input-sm mt-1"
            placeholder="Type your message here..."
            v-model="newMessage"
        @keyup.enter="sendMessage"
        />
        </div>
    </div>
</template>
<script>

export default {
    data() {
        return {
            newMessage: "",
            name: "",
        };
    },
    methods: {
        sendMessage() {
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

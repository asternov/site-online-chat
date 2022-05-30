<template>
    <div class="input-group">
        <div class="w-100 flex justify-content-center">
        <input
            type="text"
            name="name"
            class="form-control input-sm d-inline-block"
            placeholder="username"
            style="width: 15%"
            v-model="name"
        />
        <input
            id="btn-input"
            type="text"
            name="message"
            class="form-control input-sm d-inline-block"
            style="width: 75%"
            placeholder="Type your message here..."
            v-model="newMessage"
        @keyup.enter="sendMessage"
        />


            <span class="input-group-btn">
      <button class="btn btn-primary btn-sm" id="btn-chat" @click="sendMessage">
        Send
      </button>
    </span>
        </div>
    </div>
</template>
<script>

export default {
    // props: ["user"],
    data() {
        return {
            newMessage: "",
            name: "",
        };
    },
    methods: {
        sendMessage() {
            var user = { name: this.name };

            this.$emit("messagesent", {
                user: user,
                message: this.newMessage,
            });
            this.newMessage = "";
        },
    },
};
</script>

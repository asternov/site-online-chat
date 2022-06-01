<template>
    <div class="chat overflow-scroll" style="height: 250px">
        <div class="left clearfix" v-for="message in messages.slice().reverse()" :key="message.id">
                <div>
                    <strong>
                        {{ message.author.name }}:
                    </strong>
                    <button v-if="admin" class="btn btn-danger btn-sm" id="btn-chat" @click="deleteMessage(message.id)">
                        X
                    </button>
                </div>
                <p class="bg-secondary rounded d-inline-block p-1 bg-opacity-50 mb-1">
                    {{ message.message }}
                </p>
        </div>
    </div>
</template>

<script>
export default {
    props: ["messages", "admin"],
    methods: {
        deleteMessage(id) {
            this.$emit("messagedelete", {
                id: id,
            });
        },
    },
};
</script>

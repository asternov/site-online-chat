<template>
    <div class="chat overflow-scroll" id="scroll" style="overflow-x: hidden; height: 75vh">
        <div class="left clearfix" v-for="message in messages" :key="message.id">
                <div>
                    <strong class="text-primary">
                        {{ message.author.name }}:
                    </strong>
                    <button v-if="admin" class="btn btn-danger btn-sm" id="btn-chat" @click="deleteMessage(message.id)">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </div>
                <p class="d-inline-block text-white">
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
    mounted() {
        window.setTimeout(function() {
            var elem = document.getElementById('scroll');
            elem.scrollTop = elem.scrollHeight;
        }, 100);
    },
};
</script>

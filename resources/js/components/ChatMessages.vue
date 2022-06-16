<template>
    <div class="chat overflow-scroll" id="scroll" style="overflow-x: hidden; height: 75vh">
        <div class="left clearfix" v-for="message in messages" :key="message.id">
                <div>
                    <strong :style="'color: #' + message.author.color" v-if="!message.group">
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
        var x = 0;
        var intervalID = setInterval(function () {

            var elem = document.getElementById('scroll');
            elem.scrollTop = elem.scrollHeight;

            if (++x === 10) {
                window.clearInterval(intervalID);
            }
        }, 100);
    },
};
</script>

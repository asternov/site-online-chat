<template>
    <div class="chat scrollbar scrollbar-primary" id="scroll" style="overflow-y: scroll; overflow-x: hidden; height: calc(100vh - 11em);">
        <div class="left clearfix" v-for="message in messages" :key="message.id">
                <div style="margin-bottom: -5px" v-if="!message.group">
                    <strong :style="'color: #' + message.author.color">
                        {{ message.author.name }}:
                    </strong>
                    <button v-if="admin" class="btn btn-danger btn-sm" id="btn-chat" @click="deleteMessage(message.id)">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>

                    <span class="d-inline-block text-white mb-2 float-end">
                        {{ message.created_at | moment("H:mm") }}
                    </span>
                </div>
                <p class="d-inline-block text-white mb-2">
                    {{ message.message }}
                </p>
        </div>
    </div>
</template>

<script>
export default {
    props: ["messages", "admin", "wide"],
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

<template>
    <div class="chat overflow-scroll" id="scroll" :style="'overflow-x: hidden; height: ' + (wide ? 78 : 75) + 'vh'">
        <div class="left clearfix" v-for="message in messages" :key="message.id">
                <div style="margin-bottom: -5px">
                    <strong :style="'color: #' + message.author.color" v-if="!message.group">
                        {{ message.author.name }}:
                    </strong>
                    <button v-if="admin" class="btn btn-danger btn-sm" id="btn-chat" @click="deleteMessage(message.id)">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>

                    <span class="d-inline-block text-white mb-2 float-end">
                        {{ message.created_at | moment("H:mm") }}
                    </span>
                </div>
                <p class="d-inline-block text-white mb-2"  v-if="!message.group">
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

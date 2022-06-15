<template>
    <div class="chat overflow-scroll" id="scroll" style="overflow-x: hidden; height: 70vh">
        <div class="left clearfix" v-for="message in messages" :key="message.id">
                <div>
                    <strong class="text-primary">
                        {{ message.author.name }}:
                    </strong>
                    <button v-if="admin" class="btn btn-danger btn-sm" id="btn-chat" @click="deleteMessage(message.id)">
                        <i class="fa-solid fa-trash-can"></i>
                        <fa-icon class="fas fa-address-card" color="#2980B9" size="2em"></fa-icon>

                        <fa-icon [icon]="faAlignJustify"></fa-icon>
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

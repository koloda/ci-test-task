<template>
    <div class="comments-list">
        <div class="comment" v-bind:key="c.id" v-for="c in commentsList">
            <comment :comment="c">{{ c.text }}</comment>
        </div>
    </div>
</template>

<script>
import Comment from './Comment.vue';

export default {
    props: ['comments'],
    data() {
        return {
            commentsList: this.comments,
        }
    },
    components: {
        comment: Comment
    }
}
</script>
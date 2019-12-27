<template>
    <div class="comments-list">
        <div class="comment" v-bind:key="c.id" v-for="c in comments">
            <comment @commentremoved="commentRemoved" :comment="c">{{ c.text }}</comment>
        </div>
    </div>
</template>

<script>
import Comment from './Comment.vue';

export default {
    props: ['comments'],
    components: {
        comment: Comment
    },
    methods: {
        commentRemoved: function (comments) {
            this.$emit('commentremoved', comments)
        }
    }
}
</script>
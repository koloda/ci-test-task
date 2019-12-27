<script lang="ts">
import Vue from 'vue'
import LikeButton from './LikeButton.vue';
import PostComments from './PostComments.vue';
import CommentForm from './CommentForm.vue';

export default Vue.extend({
    data () {
        return {
            likesCount: this.likes,
            commentsList: this.commentsjson,
            commentsCount: this.comments
        }
    },
    props: ['header', 'published', 'post_id', 'liked', 'views', 'likes', 'comments', 'image', 'commentsjson'],
    components: {
        'like-button': LikeButton,
        'post-comments': PostComments,
        'comment-form': CommentForm,
    },
    methods: {
        likesChanged: function (n) {
            this.likesCount = n;
        },
        commentAdded: function (comments) {
            this.commentsList = comments;
            this.commentsCount = this.commentsList.length;
        }
    }
})
</script>

<template>
    <div class="post-component">
        <div class="uk-height-medium uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light" :data-src="image" uk-img>
            <h1 class="uk-text-center">{{ header }}</h1>
        </div>

        <article>
            <small>Published at: {{ published }}</small>
            <p>
                <slot></slot>
            </p>
        </article>

        <div class="uk-text-right">
            <like-button
                :entity_id="post_id"
                :liked="liked"
                entity="post"
                resource="/news"
                hint_position="before"
                @likeevent="likesChanged"
            ></like-button>
        </div>

        <hr>

        <div class="row">
            <div class="col-md">
                Views: {{ views }}
            </div>

            <div class="col-md">
                Likes: {{ likesCount }}
            </div>

            <div class="col-md">
                Comments: {{ commentsCount }}
            </div>
        </div>

        <br>
        <hr>

        <comment-form @commentadded="commentAdded" :entity_id="post_id"></comment-form>

        <hr>
        <post-comments @commentremoved="commentAdded" :comments="commentsList"></post-comments>
    </div>
</template>
<template>
    <article class="uk-comment">
        <header uk-grid="" class="uk-comment-header uk-grid-medium uk-flex-middle uk-grid">
            <div class="uk-width-auto uk-first-column">
                <img src="https://i.pravatar.cc/80?img=8" width="80" height="80" alt="" class="uk-comment-avatar">
            </div>
            <div class="uk-width-expand">
                <h4 class="uk-comment-title uk-margin-remove">
                    <a href="#" class="uk-link-reset">Author</a>
                </h4>
                <ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
                    <li>
                        <a href="#">{{ comment.created_at }}</a>
                    </li>
                    <li>Likes: {{ likesCount }}</li>
                    <li class="uk-text-right">
                        <div>
                            <like-button
                                :entity_id="comment.id"
                                :liked="comment.likedByCurrUser"
                                entity="comment"
                                resource="/comments"
                                hint_position="after"
                                @likeevent="likesChanged"
                            ></like-button>
                        </div>
                    </li>
                </ul>
            </div>
        </header>
        <div class="uk-comment-body">
            <p>
                <slot></slot>
            </p>
        </div>
    </article>
</template>

<script lang="ts">
    import Vue from 'vue';
    import LikeButton from './LikeButton.vue';

    export default Vue.extend({
        props: ['comment'],
        data () {
            return {
                likesCount: this.comment.likes
            }
        },
        components: {
            'like-button': LikeButton
        },
        methods: {
            likesChanged: function (n) {
                this.likesCount = n;
            }
        }
    })
</script>
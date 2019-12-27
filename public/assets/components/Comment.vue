<template>
    <article class="uk-comment">
        <header uk-grid="" class="uk-comment-header uk-grid-medium uk-flex-middle uk-grid">
            <div class="uk-width-auto uk-first-column">
                <img :src="imgUrl" width="80" height="80" alt="" class="uk-comment-avatar">
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
                    <li v-if="comment.createdByCurrUser">
                        <a @click="remove">Remove comment</a>
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
    import request from 'request';

    export default Vue.extend({
        props: ['comment'],
        data () {
            return {
                likesCount: this.comment.likes,
                imgUrl: 'https://i.pravatar.cc/80?img=' + this.comment.id.toString()[0]
            }
        },
        components: {
            'like-button': LikeButton
        },
        methods: {
            likesChanged: function (n) {
                this.likesCount = n;
            },
            remove: function () {
                const url =  window.location.origin + '/comments/remove/' + this.comment.id;
                let component = this;

                request.post({url}, function (e, r, body) {
                    if (r && r.statusCode == 200) {
                        const data = JSON.parse(body);

                        if (data.status == 'success') {
                            component.$emit('commentremoved', data.comments);
                            component.text = '';
                        }
                    }
                })
            }
        }
    })
</script>
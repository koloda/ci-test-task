<template>
    <div>
        <small v-if="isLiked == 1 && hint_position == 'before'">(You already liked this {{ entity }})</small>
        <a @click="like" class="uk-button uk-button-default like-button" v-bind:class="{'uk-button-primary': isLiked == 1}" >
            {{ isLiked == 1 ? 'Unlike' : 'Like ' + entity }}
        </a>
        <small v-if="isLiked == 1 && hint_position == 'after'">(You already liked this {{ entity }})</small>
    </div>
</template>

<script lang="ts">
import Vue from 'vue';
import request from 'request';

export default Vue.extend({
    props: ['liked', 'entity_id', 'entity', 'resource', 'hint_position'],
    data () {
        return {
            isLiked: this.liked
        }
    },
    methods: {
        like: function (e) {
            let url = window.location.origin;
            url += (this.isLiked == 1) ?
                this.resource + '/unlike/' + this.entity_id
                : this.resource + '/like/' + this.entity_id;
            let component = this;

            request(url, function(e, r, body) {
                if (r && r.statusCode == 200) {
                    const data = JSON.parse(body);

                    if (data.status == 'success') {
                        component.isLiked = (component.isLiked == 1) ? 0 : 1;

                        component.$emit('likeevent', data.likes);
                        console.log('emitted')
                    }
                }
            });
        }
    }
});
</script>
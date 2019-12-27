<template>
    <div class="comment-form">
        <div class="row">
            <textarea class="col-md-10" v-model="text" placeholder="Add your mention about this post"></textarea>
            <button @click="sendComment" class="col-md-2 uk-button uk-button-secondary">Add comment</button>
        </div>
    </div>
</template>

<script>
import request from 'request';

export default {
    props: ['entity_id'],
    data() {
        return {
            text: '',
        }
    },
    methods: {
        sendComment: function () {
            if (this.text.length > 0) {
                const url =  window.location.origin + '/comments/add/' + this.entity_id;
                const form = {text: this.text, news_id: this.entity_id};
                let component = this;

                request.post({url, form}, function (e, r, body) {
                    if (r && r.statusCode == 200) {
                        const data = JSON.parse(body);

                        if (data.status == 'success') {
                            component.$emit('commentadded', data.comments);
                            component.text = '';
                        }
                    }
                })
            }
        }
    }
}
</script>
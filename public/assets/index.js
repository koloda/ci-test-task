import 'uikit';
import '../../node_modules/uikit/dist/js/uikit-icons';
import './index.css';
import './less/style.less';
import Vue from 'vue/dist/vue.esm.js';

import LikeButton from './components/LikeButton';
import Post from './components/Post';
import PostComments from './components/PostComments';

new Vue ({
    el: '#post',
    data: {
        'test': 'testtext'
    },
    components: {
        'like-button': LikeButton,
        'post': Post,
        'post-comments': PostComments
    }
});


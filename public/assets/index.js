import 'uikit';
import '../../node_modules/uikit/dist/js/uikit-icons';
import './index.css';
import './less/style.less';
import Vue from 'vue/dist/vue.esm.js';

import LikeButton from './components/LikeButton';
import Comment from './components/Comment';
import Post from './components/Post';

new Vue ({
    el: '#post',
    data: {
        'test': 'testtext'
    },
    components: {
        'like-button': LikeButton,
        'comment': Comment,
        'post': Post
    }
});


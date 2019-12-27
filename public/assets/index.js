import 'uikit';
import '../../node_modules/uikit/dist/js/uikit-icons';
import './index.css';
import './less/style.less';

import Vue from 'vue/dist/vue.esm.js';
import Post from './components/Post';

new Vue ({
    el: '#post',
    data: {
        'test': 'testtext'
    },
    components: {
        'post': Post,
    }
});


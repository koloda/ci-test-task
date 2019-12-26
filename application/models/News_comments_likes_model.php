<?php

include('Likes_model.php');

class News_comments_likes_model extends Likes_model
{
    protected static $table = 'news_comments_likes';
    protected static $entity_column = 'comment_id';
    protected static $entity = 'comments';
}
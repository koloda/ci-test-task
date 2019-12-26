<?php

include('Likes_model.php');

class News_likes_model extends Likes_model
{
    protected static $table = 'news_likes';
    protected static $entity_column = 'news_id';
    protected static $entity = 'news';
}
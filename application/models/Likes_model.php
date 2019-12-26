<?php

abstract class Likes_model extends MY_Model
{
    protected $user_id;
    protected $created_at;

    protected static $entity_column;
    protected static $table;
    protected static $entity;

    public static function create(int $entity_id, string $user_id)
    {
        $db =& get_instance()->s;
        $data = [static::$entity_column => $entity_id, 'user_id' => $user_id, 'entity' => static::$entity];
        $res = $db->from(static::$table)->insert($data)->execute();

	    if (!$res) {
	        return false;
        }

	    return new static($db->insert_id);
    }

    public static function get_count(int $entity_id)
    {
        $db = &get_instance()->s;

        return $db->from(static::$table)->where([static::$entity_column => $entity_id])->count();
    }

    public static function table()
    {
        return static::$table;
    }

    public static function entity_column()
    {
        return static::$entity_column;
    }
}

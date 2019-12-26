<?php

include('traits/Likeable.php');

class News_comments_model extends MY_Model
{
    use Likeable;

    const COMMENTS_TABLE = 'news_comments';

    /** @var int */
    protected $id;

    /** @var string */
    protected $text;

    /** @var int */
    protected $created_at;

    protected $likes_class = 'News_comments_likes_model';

    function __construct($id = FALSE)
    {
        parent::__construct();
        $this->class_table = self::COMMENTS_TABLE;
        $this->set_id($id);
    }

    public static function create($data)
    {
        $db =& get_instance()->s;
        $res = $db->from(self::COMMENTS_TABLE)->insert($data)->execute();

	    if (!$res) {
	        return false;
        }

	    return new self($db->insert_id);
    }

    public function get_text(): ?string
    {
        return $this->text;
    }

    public function set_text(string $text): ?string
    {
        $this->text = $text;

        return $this->_save('text', $text);
    }

    public static function get_by_news_id(int $news_id)
    {
        $db = &get_instance()->s;
        $news = $db->from(static::COMMENTS_TABLE)
            ->where(['news_id' => $news_id])
            ->many();

        return $news;
    }

    public function like(string $user_id)
    {
        $CI = &get_instance();
        $CI->load->model('news_comments_likes_model');

        return News_comments_likes_model::create($this->id, $user_id);
    }

    public function unlike(string $user_id)
    {
        $CI = &get_instance();
        $CI->load->model('news_comments_likes_model');

        return $CI->s->from(News_comments_likes_model::table())
            ->where(['user_id' => (string) $user_id, News_comments_likes_model::entity_column() => $this->id])
            ->delete()
            ->execute();
    }
}

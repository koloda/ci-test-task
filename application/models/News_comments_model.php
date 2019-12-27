<?php

require_once('traits/Likeable.php');

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

    /** @var int */
    protected $news_id;

    /** @var string */
    protected $user_id;

    private $likes_class = 'News_comments_likes_model';

    function __construct($id = FALSE)
    {
        parent::__construct($id);
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

    public function get_created_at()
    {
        return $this->created_at;
    }

    public function get_user_id()
    {
        return $this->user_id;
    }

    public function get_news_id()
    {
        return $this->news_id;
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

    public static function get_by_news_id(int $news_id, bool $asObjects = false)
    {
        $db = &get_instance()->s;
        $news = $db->from(static::COMMENTS_TABLE)
            ->where(['news_id' => $news_id])
            ->orderBy('created_at', 'DESC')
            ->many();

        if ($asObjects) {
            $objects = [];

            foreach ($news as $n) {
                $objects[] = new self($n);
            }

            return $objects;
        }

        return $news;
    }

    public static function as_json($items, string $user_id = null): array
    {
        if (!is_array($items)) {
            $items = [$items];
        }

        $result = [];
        foreach ($items as $item) {
            /** @var News_comments_model $item */
            $result[] = [
                'id'            => $item->get_id(),
                'text'          => $item->get_text(),
                'news_id'       => $item->get_news_id(),
                'created_at'    => date('m D, Y', strtotime($item->get_created_at())),
                'likes'         => $item->get_likes(),
                'likedByCurrUser'   => $user_id ? $item->liked_by($user_id) : false,
                'createdByCurrUser' => $user_id == $item->get_user_id(),
            ];
        }

        return $result;
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

<?php

require_once('traits/Likeable.php');

/**
 * Created by PhpStorm.
 * User: mr.incognito
 * Date: 10.11.2018
 * Time: 10:10
 */
class News_model extends MY_Model
{
    use Likeable;

    const NEWS_TABLE = 'news';
    const PAGE_LIMIT = 3;

    protected $id;
    protected $header;
    protected $short_description;
    protected $text;
    protected $img;
    protected $tags;
    protected $time_created;
    protected $time_updated;
    protected $views;

    protected $comments;

    protected $likes_class = 'News_likes_model';

    function __construct($id = FALSE)
    {
        parent::__construct();
        $this->class_table = self::NEWS_TABLE;
        $this->set_id($id);
    }

    /**
     * @return string
     */
    public function get_header()
    {
        return $this->header;
    }

    /**
     * @param mixed $header
     */
    public function set_header($header)
    {
        $this->header = $header;
        return $this->_save('header', $header);
    }

    /**
     * @return string
     */
    public function get_short_description(bool $strip_tags = false, int $length = null)
    {
        $sd = $this->short_description;

        if ($strip_tags) {
            $sd = strip_tags($sd);
        }

        if ($length && mb_strlen($sd) > 300) {
            $sd = substr($sd, 0, 300) . '...';
        }

        return $sd;
    }

    /**
     * @param mixed $description
     */
    public function set_short_description($description)
    {
        $this->short_description = $description;
        return $this->_save('short_description', $description);
    }

    /**
     * @return string
     */
    public function get_full_text()
    {
        return $this->text;
    }


    /**
     * @return mixed
     */
    public function get_image()
    {
        return $this->img;
    }

    /**
     * @param mixed $image
     */
    public function set_image($image)
    {
        $this->img = $image;
        return $this->_save('image', $image);
    }

    /**
     * @return string
     */
    public function get_tags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function set_tags($tags)
    {
        $this->tags = $tags;
        return $this->_save('tags', $tags);
    }

    /**
     * @return mixed
     */
    public function get_time_created()
    {
        return $this->time_created;
    }

    /**
     * @param mixed $time_created
     */
    public function set_time_created($time_created)
    {
        $this->time_created = $time_created;
        return $this->_save('time_created', $time_created);
    }

    /**
     * @return int
     */
    public function get_time_updated()
    {
        return strtotime($this->time_updated);
    }

    /**
     * @param mixed $time_updated
     */
    public function set_time_updated($time_updated)
    {
        $this->time_updated = $time_updated;
        return $this->_save('time_updated', $time_updated);
    }

    /**
     * @return integer
     */
    public function get_views(): int
    {
        return (int) $this->views;
    }

    /**
     * @param int $views
     */
    public function set_views(int $views)
    {
        $this->views = $views;
        return $this->_save('views', $views);
    }

    /**
     * @return News_comments_model[]
     */
    public function get_comments()
    {
        if (!$this->comments) {
            $CI = &get_instance();
            $CI->load->model('news_comments_model');
            $comments = News_comments_model::get_by_news_id($this->id);
            $this->comments = [];

            foreach ($comments as $c) {
                $this->comments[] = (new News_comments_model)->load_data($c);
            }
        }

        return $this->comments;
    }

    /**
     * @param int $page
     * @param bool|string $preparation
     * @return array
     */
    public static function get_all($preparation = FALSE)
    {

        $CI =& get_instance();

        $_data = $CI->s->from(self::NEWS_TABLE)->many();

        $news_list = [];
        foreach ($_data as $_item) {
            $news_list[] = (new self())->load_data($_item);
        }

        if ($preparation === FALSE) {
            return $news_list;
        }

        return self::preparation($news_list, $preparation);
    }

        /**
     * @param int $page
     * @param bool|string $preparation
     * @return array
     */
    public static function get_last($preparation = FALSE)
    {
        $CI =& get_instance();
        $_data = $CI->s->from(self::NEWS_TABLE)
            ->orderBy('time_updated', 'DESC')
            ->limit(static::PAGE_LIMIT, 0)
            ->many();

        $news_list = [];

        foreach ($_data as $_item) {
            $news_list[] = (new self())->load_data($_item);
        }

        if ($preparation === FALSE) {
            return $news_list;
        }

        return self::preparation($news_list, $preparation);
    }

    public static function preparation($data, $preparation)
    {

        switch ($preparation) {
            case 'short_info':
                return self::_preparation_short_info($data);
            default:
                throw new Exception('undefined preparation type');
        }
    }

    /**
     * @param News_model[] $data
     * @return array
     */
    private static function _preparation_short_info($data)
    {
        $res = [];
        foreach ($data as $item) {
            $_info = new stdClass();
            $_info->id = (int)$item->get_id();
            $_info->header = $item->get_header();
            $_info->description = $item->get_short_description();
            $_info->img = $item->get_image();
            $_info->time = $item->get_time_updated();
            $_info->comments = $item->get_comments();
            $res[] = $_info;
        }
        return $res;
    }


    public static function create($data)
    {
        $CI =& get_instance();
	    $res = $CI->s->from(self::NEWS_TABLE)->insert($data)->execute();
	    if(!$res){
	        return FALSE;
        }

	    return new self($CI->s->insert_id);
    }
}

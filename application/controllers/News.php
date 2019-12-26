<?php

class News extends MY_Controller
{
    protected $response_data;

    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        $this->load->model('news_model');

        return $this->response_success(['news' => News_model::get_all('short_info'),'patch_notes' => []]);
    }

    public function comments(int $news_id)
    {
        $this->load->model('news_comments_model');

        return $this->response_success(['comments' => News_comments_model::get_by_news_id($news_id)]);
    }

    public function like(int $news_id)
    {
        $model = $this->get_news($news_id);
        $user_id = $this->get_user_id();

        try {
            $model->like($user_id);
        } catch (\Exception $e) {
            return $this->response_error('error adding like to news #' . $news_id);
        }

        return $this->response_success(['likes' => $model->get_likes()]);
    }

    public function unlike(int $news_id)
    {
        $model = $this->get_news($news_id);
        $user_id = $this->get_user_id();

        $model->unlike($user_id);

        return $this->response_success(['likes' => $model->get_likes()]);
    }

    protected function get_news(int $news_id)
    {
        $this->load->model('news_model');

        try {
            $model = new News_model($news_id);
        } catch (\Exception $e) {
            $model = null;
        }

        if (!$model) {
            echo $this->response_error('no model exist', [], 400);
            exit;
        }

        return $model;
    }

    protected function get_user_id()
    {
        if (php_sapi_name() === 'cli') {
            //stub for cli user id
            return md5('cli');
        } else {
            //we have not auth system - unique user id is IP+UserAgent
            return md5($this->input->ip_address() .  $_SERVER['HTTP_USER_AGENT']);
        }
    }
}

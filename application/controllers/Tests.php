<?php

/**
 * Created by PhpStorm.
 * User: mr.incognito
 * Date: 10.11.2018
 * Time: 21:36
 */
class Tests extends MY_Controller
{
    protected $response_data;

    public function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
        $this->load->model('news_model');

        if (ENVIRONMENT === 'production')
        {
            die('Access denied!');
        }
    }

    // костыль для тестов)
    public function index()
    {
        $this->get_last_news();
    }

    public function get_last_news()
    {
        return $this->response_success(['news' => News_model::get_all('short_info'),'patch_notes' => []]);
    }

    public function get_comments(int $news_id){ // or can be $this->input->post('news_id')
        // for example: get all comments by api request :)
        return $this->response_error('not_implemented');
    }


    
}

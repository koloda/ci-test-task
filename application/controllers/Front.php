<?php

/**
 * @property CI_Loader $load
 */
class Front extends MY_Controller
{
    public function index()
    {
        $this->load->model('news_model');
        $models = News_model::get_last();

        return $this->render('front/index', compact('models'));
    }

    public function view(int $news_id)
    {
        $this->load->model('news_model');
        $model = new News_model($news_id);
        $model->set_views($model->get_views() + 1);
        $user_id = md5($this->input->ip_address() .  $_SERVER['HTTP_USER_AGENT']);

        if (!$model) {
            show_404();
        }

        return $this->render('front/view', compact('model', 'user_id'));
    }
}

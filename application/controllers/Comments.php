<?php

class Comments extends MY_Controller
{
    public function like(int $comment_id)
    {
        $model = $this->get_comment($comment_id);
        $user_id = $this->get_user_id();

        try {
            $model->like($user_id);
        } catch (\Exception $e) {
            return $this->response_error('error adding like to comment #' . $comment_id);
        }

        return $this->response_success(['likes' => $model->get_likes()]);
    }

    public function unlike(int $comment_id)
    {
        $model = $this->get_comment($comment_id);
        $user_id = $this->get_user_id();

        $model->unlike($user_id);

        return $this->response_success(['likes' => $model->get_likes()]);
    }

    public function add(int $news_id, string $text = null)
    {
        if (!$text) { $text = $this->input->post('text'); }
        $user_id = $this->get_user_id();

        $this->load->model('news_comments_model');
        News_comments_model::create(compact('news_id', 'user_id', 'text'));
        $comments = News_comments_model::get_by_news_id($news_id, true);

        return $this->response_success(['comments' => News_comments_model::as_json($comments, $user_id)]);
    }

    public function remove(int $comment_id)
    {
        $comment = $this->get_comment($comment_id);
        $user_id = $this->get_user_id();

        if (!$comment || $comment->get_user_id() != $user_id) {
            return $this->response_error(400, 'Action not allowed');
        }

        $news_id = $comment->get_news_id();
        $this->load->model('news_comments_model');
        $db = &get_instance()->s;
        $db->from(News_comments_model::COMMENTS_TABLE)
            ->where(['id' => $comment_id])
            ->delete()
            ->execute();

        $comments = News_comments_model::get_by_news_id($news_id, true);

        return $this->response_success(['comments' => News_comments_model::as_json($comments, $user_id)]);
    }

    /**
     * @param integer $comment_id
     *
     * @return News_comments_model|null
     */
    protected function get_comment(int $comment_id)
    {
        $this->load->model('news_comments_model');

        try {
            $model = new News_comments_model($comment_id);
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

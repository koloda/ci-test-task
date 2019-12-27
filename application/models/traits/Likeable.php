<?php

trait Likeable
{
    protected $likes;

    public function get_likes()
    {
        if ($this->likes === null) {
            $cls = $this->likes_class;
            $CI = &get_instance();
            $CI->load->model(strtolower($cls));
            $this->likes = $cls::get_count($this->id);
        }

        return $this->likes;
    }

    public function like(string $user_id)
    {
        $cls = $this->likes_class;
        $CI = &get_instance();
        $CI->load->model(strtolower($cls));

        return $cls::create($this->id, $user_id);
    }

    public function unlike(string $user_id)
    {
        $cls = $this->likes_class;
        $CI = &get_instance();
        $CI->load->model(strtolower($cls));

        return $CI->s->from($cls::table())
            ->where(['user_id' => (string) $user_id, $cls::entity_column() => $this->id])
            ->delete()
            ->execute();
    }

    public function liked_by(string $user_id)
    {
        $cls = $this->likes_class;
        $CI = &get_instance();
        $CI->load->model(strtolower($cls));

        return $CI->s->from($cls::table())
            ->where(['user_id' => (string) $user_id, $cls::entity_column() => $this->id])
            ->count();
    }
}
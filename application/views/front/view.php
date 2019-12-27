<?php
/**
 * @var News_model $model
 * @var int $user_id
 * @var string $comments_json
 */
?>

<div class="uk-container" id="post">
    <post
        header="<?= $model->get_header() ?>"
        image="<?= $model->get_image() ?>"
        published="<?= date('m D, Y', $model->get_time_updated()) ?>"
        post_id="<?= $model->get_id() ?>"
        liked="<?= $model->liked_by($user_id) ?>"
        views="<?= $model->get_views() ?>"
        likes="<?= $model->get_likes() ?>"
        comments="<?= count($model->get_comments()) ?>"
        :commentsjson="<?= str_replace('"', '\'', $comments_json) ?>"
    >
    <?= $model->get_full_text() ?>
    </post>
</div>
<?php
/**
 * @var News_model $model
 * @var int $user_id
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
    >
    <?= $model->get_full_text() ?>
    </post>
    <hr>
    <?php foreach ($model->get_comments() as $comment): ?>
        <comment
            text="<?= $comment->get_text() ?>"
            likes="<?= $comment->get_likes() ?>"
            created="<?= date('m D, Y', $comment->get_created_at()) ?>"
            comment_id="<?= $comment->get_id() ?>"
            liked="<?= (int) $comment->liked_by($user_id) ?>"
        >
        </comment>
    <?php endforeach; ?>
</div>
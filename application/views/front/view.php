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

<hr>
<div class="popular-news uk-text-center uk-container">
    <h2>Popular news</h2>

    <div class="row">
        <?php foreach ($popular as $model): ?>
            <!-- <div class=""> -->
                <div class="col-md">
                <div class="uk-card-default uk-card">
                    <div class="uk-card-media-top">
                        <img src="<?= $model->get_image() ?>" alt="<?= $model->get_header() ?>">
                    </div>
                    <div class="uk-card-body">
                        <a href="/front/view/<?= $model->get_id() ?>" class="uk-card-title">
                            <h3><?= $model->get_header() ?></h3>
                        </a>
                        <p><?= $model->get_short_description(true, 300) ?></p>

                        <small>
                            <span uk-icon="calendar"></span>
                            <?= date('M d, Y', $model->get_time_updated()) ?>
                        </small>
                    </div>
                </div>
                </div>
            <!-- </div> -->
        <?php endforeach; ?>
    </div>
</div>
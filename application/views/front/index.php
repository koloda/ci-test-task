<?php
/**
 * @var News_model[] $models
 */
?>
<div class="uk-container">
    <h1 class="uk-text-center">Last news</h1>
    <div class="row">
        <?php foreach ($models as $model): ?>
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
<?php
/* @var $this yii\web\View */

use yeesoft\post\models\Post;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $post yeesoft\post\models\Post */

$this->title = $post->title;
$this->params['breadcrumbs'][] = $post->title;
?>


    <div class="post clearfix">
        <h2><?= $post->title ?></h2>

        <p class="pull-left">
            <span >由 <?= $post->author->username ?> 发布于 <?= $post->publishedDate ?></span>
        </p>

        <div class="clearfix" style="margin-bottom: 10px;">
            <div class="pull-left">
                <?php if ($post->category): ?>
                    <?= Html::a($post->category->title, 'javascript:void(0);', ['class' => 'label label-primary']) ?>
                <?php endif; ?>
            </div>
            <div class="pull-right">
                <?php $tags = $post->tags; ?>
                <?php if (!empty($tags)): ?>
                    <?php foreach ($tags as $tag): ?>
                        <?= Html::a('#' . $tag->title, 'javascript:void(0);', ['class' => 'label label-primary']) ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="text-justify" style="clear:both;">
            <?= $post->content ?>
        </div>
    </div>
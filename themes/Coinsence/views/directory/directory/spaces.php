<?php
/* @var $this \yii\web\View */
/* @var $keyword string */
/* @var $spaces humhub\modules\space\models\Space[] */

/* @var $pagination yii\data\Pagination */

use humhub\libs\Helpers;
use humhub\libs\Html;
use humhub\modules\directory\widgets\SpaceTagList;
use humhub\modules\space\widgets\FollowButton;
use humhub\modules\space\widgets\Image;
use humhub\widgets\LinkPager;
use yii\helpers\Url;

?>
<div class="panel panel-default">

    <div class="panel-heading">
        <?= Yii::t('DirectoryModule.base', '<strong>Space</strong> directory'); ?>
    </div>

    <div class="panel-body">
        <?= Html::beginForm(Url::to(['/directory/directory/spaces']), 'get', ['class' => 'form-search']); ?>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <!-- TODO: test if user have space creation permission -->
                <div class="add-new-space">
                    <a href="#" class="btn btn-info col-md-12" data-action-click="ui.modal.load" data-action-url="<?= Url::to(['/space/create/create']) ?>">
                        <?= Yii::t('SpaceModule.widgets_views_spaceChooser', 'Create new space') ?>
                    </a>
                </div>
                <div class="form-group form-group-search">
                    <?= Html::textInput('keyword', $keyword, ['class' => 'form-control form-search', 'placeholder' => Yii::t('DirectoryModule.base', 'search for spaces')]); ?>
                    <?= Html::submitButton(Yii::t('DirectoryModule.base', 'Search'), ['class' => 'btn btn-default btn-sm form-button-search']); ?>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
        <?= Html::endForm(); ?>

        <?php if (count($spaces) == 0): ?>
            <p><?= Yii::t('DirectoryModule.base', 'No spaces found!'); ?></p>
        <?php endif; ?>
    </div>

    <hr>
    <ul class="media-list">
        <?php foreach ($spaces as $space) : ?>
            <li>
                <div class="media">
                    <div class="pull-right">
                        <?=
                        FollowButton::widget([
                            'space' => $space,
                            'followOptions' => ['class' => 'btn btn-default btn-sm'],
                            'unfollowOptions' => ['class' => 'btn btn-default btn-sm']
                        ]);
                        ?>
                    </div>

                    <?= Image::widget([
                        'space' => $space, 'width' => 50,
                        'htmlOptions' => [
                            'class' => 'media-object',
                            'data-contentcontainer-id' => $space->contentcontainer_id
                        ],
                        'linkOptions' => ['class' => 'pull-left'],
                        'link' => true,
                    ]); ?>

                    <?php if ($space->isMember()): ?>
                        <i class="fa fa-user space-member-sign tt" data-toggle="tooltip" data-placement="top" title=""
                           data-original-title="<?= Yii::t('DirectoryModule.base', 'You are a member of this space'); ?>"></i>
                    <?php endif; ?>

                    <div class="media-body">

                        <a data-contentcontainer-id="<?= $space->contentcontainer_id; ?>" href="<?= $space->getUrl(); ?>">
                            <h4 class="media-heading">
                                <p><?= $space->getDisplayName(); ?></p>
                                <?php if ($space->isArchived()) : ?>
                                    <span
                                            class="label label-warning"><?= Yii::t('ContentModule.widgets_views_label', 'Archived'); ?></span>
                                <?php endif; ?>
                                <h5><?= Html::encode(Helpers::truncateText($space->description, 100)); ?></h5>

                            </h4>
                        </a>

                    </a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="pagination-container">
    <?= LinkPager::widget(['pagination' => $pagination]); ?>
</div>

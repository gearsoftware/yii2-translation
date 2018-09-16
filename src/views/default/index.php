<?php

/**
 * @package   Yii2-Translation
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\helpers\Html;
use gearsoftware\models\User;
use gearsoftware\widgets\ActiveForm;

/* @var $this gearsoftware\web\View */

$this->title = Yii::t('core/translation', 'Message Translation');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="message-index">

        <div class="row">
            <div class="col-sm-12">
                <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
                <?= Html::a(Yii::t('core/translation', 'Add New Source Message'), ['/translation/source/create'], ['class' => 'btn btn-sm btn-primary']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body translation">

                        <ul class="list-group">
                            <?php foreach ($categories as $category => $count) : ?>
                                <li>
                                    <h4 style="margin-bottom: 0;">
                                        <b>[<?= strtoupper($category) ?>]</b>
                                        <?= Yii::t('core/translation', '{n, plural, =1{1 message} other{# messages}}', ['n' => $count]) ?>
                                    </h4>

                                    <?php foreach ($languages as $language => $languageLabel) : ?>
                                        <?php $link = ['/translation/default/index', 'category' => $category, 'translation' => $language] ?>
                                        <?php $options = (($currentLanguage == $language) && ($currentCategory == $category)) ? ['class' => 'active'] : [] ?>
                                        <?= Html::a("<span class='label label-default'>$languageLabel</span>", $link, $options) ?>
                                    <?php endforeach; ?>

                                </li>
                            <?php endforeach; ?>
                        </ul>

                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <?php if (!$currentLanguage || !$currentCategory): ?>
                            <h4>
                                <?= Yii::t('core/translation', 'Please, select message group and language to view translations...') ?>
                            </h4>
                        <?php else: ?>

                            <?php $form = ActiveForm::begin() ?>

                            <?php foreach ($messages as $index => $message) : ?>
                                <?php
                                $links = '';
                                if (User::hasPermission('updateSourceMessages') && (!$message->source->immutable || User::hasPermission('updateImmutableSourceMessages'))) {
                                    $links .= ' ' . Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', ['/translation/source/update', 'id' => $message->source_id]);
                                }
                                ?>

                                <?= $form->field($message, "[$index]translation")->label($message->source->message . $links) ?>

                            <?php endforeach; ?>

                            <?php if (User::hasPermission('updateSourceMessages')): ?>
                                <?= Html::submitButton(Yii::t('core', 'Save All'), ['class' => 'btn btn-primary']) ?>
                            <?php endif; ?>

                            <?php ActiveForm::end() ?>

                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

    </div>

<?php
$this->registerCss("
    .translation li{
        display: block;
    }

    .translation li a:hover{
        text-decoration:none;
    }

    .translation li a:hover .label-default, .translation li a.active .label-default {
        background-color: #38a0f4;
        border-color: #42a5f5;
        color: #fff;
    }
    
    .translation li a {
        display: inline-block;
        padding-bottom: 4px;
    }
");
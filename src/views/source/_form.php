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
use gearsoftware\translation\models\MessageSource;
use yii\helpers\ArrayHelper;
use yii\web\View;
use gearsoftware\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model gearsoftware\translation\models\MessageSource */
/* @var $form gearsoftware\widgets\ActiveForm */
?>

    <div class="message-source-form">

        <?php
        $form = ActiveForm::begin([
            'id' => 'message-source-form',
            'validateOnBlur' => false,
            'enableClientValidation' => false,
        ])
        ?>

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-6">
                                <?php $categories = ArrayHelper::merge(MessageSource::getCategories(), [' ' => Yii::t('core/translation', 'Create New Category')]) ?>
                                <?= $form->field($model, 'category')->dropDownList($categories, ['prompt' => '']) ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group new-category-group">
                                    <label class="control-label"
                                           for="new-category"><?= Yii::t('core/translation', 'New Category Name') ?></label>
                                    <input type="text" id="new-category" class="form-control" name="category"
                                           value="<?= Yii::$app->getRequest()->post('category') ?>">
                                </div>
                            </div>
                        </div>

                        <?= $form->field($model, 'message')->textInput(['rows' => 6]) ?>

                    </div>
                </div>
            </div>

            <div class="col-md-3">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="record-info">
                            <div class="form-group clearfix">
                                <?= $form->field($model, 'immutable')->checkbox() ?>
                            </div>

                            <div class="form-group">
                                <?php if ($model->isNewRecord): ?>
                                    <?= Html::submitButton(Yii::t('core', 'Create'), ['class' => 'btn btn-primary']) ?>
                                    <?= Html::a(Yii::t('core', 'Cancel'), ['/translation/default/index'], ['class' => 'btn btn-default']) ?>
                                <?php else: ?>
                                    <?= Html::submitButton(Yii::t('core', 'Save'), ['class' => 'btn btn-primary']) ?>
                                    <?=
                                    Html::a(Yii::t('core', 'Delete'), ['/translation/source/delete', 'id' => $model->id], [
                                        'class' => 'btn btn-default',
                                        'data' => [
                                            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            'method' => 'post',
                                        ],
                                    ])
                                    ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
<?php

$this->registerJs("

    //alert('|'+$('#messagesource-category').val().length+'|');
    if($('#messagesource-category').val() !== ' '){
        $('.new-category-group').hide();
    } else {
        $('.new-category-group').show();
    }

    if($('#new-category').val().length > 0){
        $('.new-category-group').show();
        $('#messagesource-category option').last().attr('selected','selected');
        $('#messagesource-category').trigger('refresh');
    }

    $('#messagesource-category').change(function(){
        if($(this).val() !== ' '){
            $('.new-category-group').hide();
        } else {
            $('.new-category-group').show();
        }
    });
", View::POS_READY);
?>
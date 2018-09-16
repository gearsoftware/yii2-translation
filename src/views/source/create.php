<?php

/**
 * @package   Yii2-Translation
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model gearsoftware\translation\models\MessageSource */

$this->title = Yii::t('core/translation', 'Create Message Source');
$this->params['breadcrumbs'][] = ['label' => Yii::t('core/translation', 'Message Translation'), 'url' => ['/translation/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="message-source-create">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>
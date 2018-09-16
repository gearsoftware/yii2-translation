<?php

/**
 * @package   Yii2-Translation
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

namespace gearsoftware\translation\controllers;

use gearsoftware\controllers\BaseController;
use gearsoftware\models\User;
use Yii;
use yii\web\ForbiddenHttpException;

/**
 * SourceController implements the CRUD actions for gearsoftware\translation\models\MessageSource model.
 */
class SourceController extends BaseController
{
    public $modelClass = 'gearsoftware\translation\models\MessageSource';
    public $enableOnlyActions = ['update', 'create', 'delete'];

    protected function getRedirectPage($action, $model = null)
    {
        switch ($action) {
            case 'update':
                return ['update', 'id' => $model->id];
                break;
            case 'create':
                return ['update', 'id' => $model->id];
                break;
            case 'delete':
                return ['/translation/default/index'];
                break;
            default:
                return parent::getRedirectPage($action, $model);
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new $this->modelClass;

        if ($model->load(Yii::$app->request->post())) {
            if (!$model->category || $model->category == ' ') {
                $model->category = trim(Yii::$app->request->post('category'));
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('info', Yii::t('core', 'Your item has been created.'));
                return $this->redirect($this->getRedirectPage('create', $model));
            }
        }

        return $this->renderIsAjax('create', compact('model'));
    }

    /**
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->immutable && !User::hasPermission('updateImmutableSourceMessages')) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }

        if ($model->load(Yii::$app->request->post())) {
            if (!$model->category) {
                $model->category = Yii::$app->request->post('category');
            }

            // print_r($model);die;

            if ($model->save()) {
	            Yii::$app->session->setFlash('mint', Yii::t('core', 'Your item has been updated.'));
                return $this->redirect($this->getRedirectPage('update', $model));
            }
        }
        return $this->renderIsAjax('update', compact('model'));
    }

    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->immutable && !User::hasPermission('updateImmutableSourceMessages')) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }

        $model->delete();

	    Yii::$app->session->setFlash('success', Yii::t('core', 'Your item has been deleted.'));
        return $this->redirect($this->getRedirectPage('delete', $model));
    }
}
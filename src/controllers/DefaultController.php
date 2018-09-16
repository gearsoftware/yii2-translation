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
use gearsoftware\translation\models\Message;
use gearsoftware\translation\models\MessageSource;
use Yii;
use yii\base\Model;

/**
 * MessageController implements the CRUD actions for gearsoftware\translation\models\Message model.
 */
class DefaultController extends BaseController
{
    public $modelClass = 'gearsoftware\translation\models\Message';
    public $enableOnlyActions = ['index'];

    /**
     * Lists all models.
     * @return mixed
     */
    public function actionIndex()
    {
        $sourceLanguage = 'en-US';

        $languages = Yii::$app->core->languages;
        $categories = MessageSource::getMessageCategories();

        unset($languages[$sourceLanguage]);

        $currentLanguage = Yii::$app->getRequest()->get('translation', NULL);
        $currentCategory = Yii::$app->getRequest()->get('category', NULL);

        if (!in_array($currentLanguage, array_keys($languages))) {
            $currentLanguage = NULL;
        }

        if (!in_array($currentCategory, array_keys($categories))) {
            $currentCategory = NULL;
        }

        if ($currentLanguage && $currentCategory) {

            Message::initMessages($currentCategory, $currentLanguage);

            $messageIds = MessageSource::getMessageIdsByCategory($currentCategory);
            $sourceTable = MessageSource::tableName();
            $messageTable = Message::tableName();

            $messages = Message::find()
                ->andWhere(['IN', 'source_id', $messageIds])
                ->andWhere(['language' => $currentLanguage])
                ->indexBy('id')
                ->all();
        } else {
            $messages = [];
        }

        if (User::hasPermission('updateTranslations') && Message::loadMultiple($messages, Yii::$app->request->post())
            && Model::validateMultiple($messages)
        ) {
            foreach ($messages as $message) {
                $message->save(false);
            }

            Yii::$app->session->setFlash('mint', Yii::t('core', 'Your item has been updated.'));
            return $this->refresh();
        }

        return $this->render('index', [
            'messages' => $messages,
            'languages' => $languages,
            'categories' => $categories,
            'currentLanguage' => $currentLanguage,
            'currentCategory' => $currentCategory,
        ]);
    }
}
<?php

/**
 * @package   Yii2-Translation
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

namespace gearsoftware\translation\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property integer $source_id
 * @property string $language
 * @property string $translation
 *
 * @property MessageSource $id0
 */
class Message extends \gearsoftware\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_id', 'language'], 'required'],
            [['source_id'], 'integer'],
            [['translation'], 'string'],
            [['language'], 'string', 'max' => 16]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(MessageSource::className(), ['id' => 'source_id']);
    }

    /**
     * @inheritdoc
     */
    public static function initMessages($category, $language)
    {
        $messageIds = MessageSource::getMessageIdsByCategory($category);

        $translations = Message::find()
            ->select('source_id')
            ->andWhere(['IN', 'source_id', $messageIds])
            ->andWhere(['language' => $language])
            ->all();

        $translationIds = array_map(function ($translation) {
            return $translation->source_id;
        }, $translations);

        $translationsToCreate = array_diff($messageIds, $translationIds);

        foreach ($translationsToCreate as $translationId) {
            $message = new Message();
            $message->source_id = $translationId;
            $message->language = $language;
            $message->translation = '';
            $message->save();
        }

        return true;
    }
}
<?php

/**
 * @package   Yii2-Translation
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

class m170731_071740_i18n_es_menu_translations extends  yii\db\Migration
{
	public function up()
	{
		$this->insert('{{%menu_link_lang}}', ['link_id' => 'settings-translations', 'label' => 'Traducción', 'language' => 'es-ES']);
	}
}

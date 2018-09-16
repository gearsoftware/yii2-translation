<?php

/**
 * @package   Yii2-Translation
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\db\TranslatedMessagesMigration;

class m170731_070742_i18n_es_core_translation extends TranslatedMessagesMigration
{
	public function getLanguage()
	{
		return 'es-ES';
	}

	public function getCategory()
	{
		return 'core/translation';
	}

	public function getTranslations()
	{
		return [
			'Add New Source Message' => 'Añadir nuevo mensaje fuente',
			'Category' => 'Categoría',
			'Create Message Source' => 'Crear mensaje fuente',
			'Create New Category' => 'Crear una nueva categoría',
			'Immutable' => 'Inmutable',
			'Message Translation' => 'Traducción de mensajes',
			'New Category Name' => 'Nombre de la nueva categoría',
			'Please, select message group and language to view translations...' => 'Por favor, seleccione el grupo de mensajes y el idioma para ver las traducciones...',
			'Source Message' => 'Mensaje fuente',
			'Update Message Source' => 'Actualizar mensaje fuente',
			'{n, plural, =1{1 message} other{# messages}}' => '{n, plural, =1{1 mensaje} other{# mensajes}}',
		];
	}
}

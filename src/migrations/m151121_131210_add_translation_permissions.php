<?php

/**
 * @package   Yii2-Translation
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\db\PermissionsMigration;

class m151121_131210_add_translation_permissions extends PermissionsMigration
{

    public function beforeUp()
    {
        $this->addPermissionsGroup('translations', 'Translations');
    }

    public function afterDown()
    {
        $this->deletePermissionsGroup('translations');
    }

    public function getPermissions()
    {
        return [
            'translations' => [
                'links' => [
                    '/admin/translation/*',
                    '/admin/translation/default/*',
                    '/admin/translation/source/*',
                ],
                'viewTranslations' => [
                    'title' => 'View Message Translations',
                    'roles' => [self::ROLE_PRINCIPAL],
                    'links' => [
                        '/admin/translation/default/index',
                    ],
                ],
                'updateTranslations' => [
                    'title' => 'Update Message Translations',
                    'roles' => [self::ROLE_PRINCIPAL],
                    'childs' => ['viewTranslations'],
                ],
                'createSourceMessages' => [
                    'title' => 'Create Source Messages',
                    'roles' => [self::ROLE_PRINCIPAL],
                    'childs' => ['viewTranslations', 'updateSourceMessages'],
                    'links' => [
                        '/admin/translation/source/create',
                    ],
                ],
                'updateSourceMessages' => [
                    'title' => 'Update Source Messages',
                    'roles' => [self::ROLE_PRINCIPAL],
                    'childs' => ['viewTranslations', 'updateTranslations'],
                    'links' => [
                        '/admin/translation/source/update',
                    ],
                ],
                'deleteSourceMessages' => [
                    'title' => 'Delete Source Messages',
                    'roles' => [self::ROLE_PRINCIPAL],
                    'childs' => ['viewTranslations', 'updateSourceMessages'],
                    'links' => [
                        '/admin/translation/source/delete',
                    ],
                ],
                'updateImmutableSourceMessages' => [
                    'title' => 'Update Immutable Source Messages',
                    'childs' => ['viewTranslations', 'updateSourceMessages'],
                ],
            ],
        ];
    }

}

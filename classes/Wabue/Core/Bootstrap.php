<?php

namespace Wabue\Core;

use Elgg\DefaultPluginBootstrap;
use Elgg\Event;
use ElggUser;

/**
 * Boostrap class for Wabue
 */
class Bootstrap extends DefaultPluginBootstrap
{
    public static array $private_fields = ['street', 'zip', 'city', 'birthday', 'anniversary', 'common'];

    /**
     * Set a private access level to specific profile fields
     * @param Event $event
     * @return void
     */
    public static function setFieldsAccessLevel(Event $event): void
    {
        foreach (Bootstrap::$private_fields as $metadata) {
            $entity = $event->getEntityParam();

            if ($entity instanceof ElggUser) {
                $entity->setProfileData($metadata, $entity->getProfileData($metadata));
            }
        }
    }

    public static function testmodeValid(): bool
    {
        $pluginList = elgg_get_plugins();
        $correctPosition = false;
        if ($pluginList[count($pluginList) - 1]->getId() == 'filetransport') {
            $correctPosition = true;
        } elseif (
            $pluginList[count($pluginList) - 1]->getId() == 'wabue' &&
            $pluginList[count($pluginList) - 2]->getId() == 'filetransport'
        ) {
            $correctPosition = true;
        }
        return !is_null(elgg_get_plugin_from_id('filetransport')) &&
            elgg_is_active_plugin('filetransport') &&
            $correctPosition;
    }

    public function init(): void
    {
        // Set private access level on defined fields
        elgg_register_event_handler('profileupdate', 'user', '\Wabue\Core\Bootstrap::setFieldsAccessLevel');
        elgg_register_event_handler('create', 'user', '\Wabue\Core\Bootstrap::setFieldsAccessLevel', 999);
    }
}

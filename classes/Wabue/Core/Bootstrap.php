<?php

namespace Wabue\Core;

use Elgg\DefaultPluginBootstrap;
use ElggPlugin;

class Bootstrap extends DefaultPluginBootstrap
{
    public static $private_fields = ['street', 'zip', 'city', 'birthday', 'anniversary', 'common'];

    /**
     * Force access level for private fields to private
     * @param $object \ElggMetadata
     */
    public static function set_fields_accesslevel($event, $object_type, $object)
    {
        foreach (Bootstrap::$private_fields as $metadata) {
            $object->setProfileData($metadata, $object->getProfileData($metadata), ACCESS_PRIVATE);
        }
        return true;
    }

    public static function testmodeValid()
    {
        /** @var ElggPlugin[] $pluginList */
        $pluginList = elgg_get_plugins('active');
        $correctPosition = $pluginList[count($pluginList) - 1]->getId() == 'filetransport' || ($pluginList[count($pluginList) - 1]->getId() == 'wabue' && $pluginList[count($pluginList) - 2]->getId() == 'filetransport');
        return elgg_plugin_exists('filetransport') && elgg_is_active_plugin('filetransport') && $correctPosition;
    }

    /**
     * Add the required spec for HtmlAwed to allow toc
     */
    public static function addTocPluginHtmlAwedConfig($hook, $type, $value, $params)
    {
        $value['unique_ids'] = 0;
        return $value;
    }

    public function init()
    {
        // Register Wabue CSS modifications
        elgg_extend_view('elements/layout.css', 'css/wabue');

        // Walled Garden CSS extensions
        elgg_extend_view('walled_garden.css', 'walled_garden_title.css', 450);

        // hide irrelevant fields from event editor
        elgg_extend_view('resources/event_calendar/edit', 'event_calendar/edit', 450);

        // Register E-Mail address to profile view
        elgg_extend_view('profile/details', 'profile/email');

        // Show extra fields automatically on useradd
        elgg_extend_view('forms/useradd', 'forms/useradd_profile_fix', 999);

        // Disable editing of special fields in profile
        elgg_extend_view('resources/profile/edit', 'profile/edit', 450);

        // Add region select to event calendar sidebar
        elgg_extend_view('event_calendar/sidebar', 'event_calendar/sidebar_region_select', 450);

        // Add "import from excel" as to the calendar navigation
        elgg_extend_view('event_calendar/show_events', 'event_calendar/navigation_appointments_import', 450);

        // Set private access level on defined fields
        elgg_register_event_handler('profileupdate', 'user', '\Wabue\Core\Bootstrap::set_fields_accesslevel');
        elgg_register_event_handler('create', 'user', '\Wabue\Core\Bootstrap::set_fields_accesslevel', 999);

        // Set the right configuration required for the TOC plugin (https://github.com/Elgg/Elgg/issues/12934)
        elgg_register_plugin_hook_handler('config', 'htmlawed', '\Wabue\Core\Bootstrap::addTocPluginHtmlAwedConfig');

        // Allow duplicate address on usersettings:save (https://github.com/Elgg/Elgg/issues/12936)
        elgg_unregister_plugin_hook_handler('usersettings:save', 'user', '_elgg_set_user_email');
        elgg_register_plugin_hook_handler('usersettings:save', 'user', '\Wabue\Core\UserSettings::save');

        $webService = new WebService();
        $webService->register();
    }
}

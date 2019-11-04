<?php

namespace Wabue;

class ConfigurePluginsCommand extends \Elgg\Cli\Command {

    protected static $defaultName = 'wabue:configure';

    protected function configure() {
        $this->setDescription('Configure the installed plugins to the default settings');
        $this->setHelp('This command configures several options of the required plugins');
    }

    protected function command() {
        # Enable view change for event calendar

        elgg_set_plugin_setting('allow_view_change', 'yes', 'event_calendar');

        # Enable polls globally and for forum group
        elgg_set_plugin_setting('enable_site', 'yes', 'poll');
        elgg_set_plugin_setting('enable_group', 'yes', 'poll');
        get_entity(45105)->enableTool('poll');

        return 0;
    }
}
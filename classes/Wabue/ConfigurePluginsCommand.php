<?php

namespace Wabue;

class ConfigurePluginsCommand extends \Elgg\Cli\Command {

    public function __construct() {
        parent::__construct('wabue:configure');
        $this->setDescription('Configure the installed plugins to the default settings');
    }

    protected function command() {
        elgg_set_plugin_setting('allow_view_change', 'yes', 'event_calendar');
        elgg_set_plugin_setting('enable_site', 'yes', 'poll');
        elgg_set_plugin_setting('enable_group', 'yes', 'poll');

        return 0;
    }
}
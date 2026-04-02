<?php

namespace Wabue\Core;

use Elgg\Cli\Command;
use Symfony\Component\Console\Input\InputArgument;

class PluginSettingsCommand extends Command
{
    protected static $defaultName = 'wabue:pluginsettings';

    protected function configure(): void
    {
        $this->setDescription('Manage the settings of plugins');
        $this->setHelp('Get and set the settings of specific plugins');
        $this->addArgument('mode', InputArgument::REQUIRED, "Mode to use (get/set/list)");
        $this->addArgument('plugin', InputArgument::REQUIRED, "Name of the plugin");
        $this->addArgument('setting', InputArgument::OPTIONAL, "Name of the setting (required for get/set)");
        $this->addArgument('value', InputArgument::OPTIONAL, "Value of the setting (required for set)");
    }

    protected function command(): int
    {
        $mode = $this->argument('mode');
        $plugin_id = $this->argument('plugin');
        $setting = $this->argument('setting');
        $value = $this->argument('value');

        if (!in_array($mode, ['list', 'get', 'set'])) {
            $this->write("Invalid mode $mode", 'error');
            return 1;
        }

        if ($mode == 'get' && is_null($setting)) {
            $this->write('No setting specified for get command', 'error');
            return 1;
        }

        if ($mode == 'set' && (is_null($setting) || is_null($value))) {
            $this->write('Set command requires a setting and a value', 'error');
        }

        $plugin = elgg_get_plugin_from_id($plugin_id);

        if (is_null($plugin)) {
            $this->write("Plugin $plugin_id not found", 'error');
            return 1;
        }

        switch ($mode) {
            case 'list':
                foreach ($plugin->getAllSettings() as $key => $value) {
                    $this->write("$key = $value");
                }
                break;
            case 'get':
                $this->write($plugin->getSetting($setting));
                break;
            case 'set':
                if (!$plugin->setSetting($setting, $value)) {
                    $this->write('Coud not set setting.', 'error');
                    return 1;
                }
                break;
        }

        return 0;
    }
}

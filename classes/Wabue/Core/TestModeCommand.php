<?php

namespace Wabue\Core;

use Symfony\Component\Console\Input\InputOption;

class TestModeCommand extends \Elgg\Cli\Command {

    protected static $defaultName = 'wabue:testmode';

    protected function configure() {
        $this->setDescription('Control the testmode');
        $this->setHelp('This command can control the testmode setting of the Wabue plugin');
        $this->addOption('testmode', 't', InputOption::VALUE_REQUIRED, 'Configure testmode (off/on)');

    }

    protected function command() {
        if ($this->option('testmode')) {
            $value = $this->option('testmode');
            elgg_set_plugin_setting('testmode', $value, 'wabue');
            echo "Set testmode to $value";
        } else {
            $value = elgg_get_plugin_setting('testmode', 'wabue');
            echo "Testmode is set to $value";
        }
        return 0;
    }
}

<?php

namespace Wabue\Core;

use Elgg\Cli\Command;
use Symfony\Component\Console\Input\InputOption;

class TestModeCommand extends Command
{
    protected static $defaultName = 'wabue:testmode';

    protected function configure(): void
    {
        $this->setDescription('Control the testmode');
        $this->setHelp('This command can control the testmode setting of the Wabue plugin');
        $this->addOption('testmode', 't', InputOption::VALUE_REQUIRED, 'Configure testmode (off/on)');
    }

    protected function command(): int
    {
        if (!Bootstrap::testmodeValid()) {
            echo 'Testmode can not be changed, because the filetransport 
            module was not active or not the last active plugin.';
            return 1;
        }
        if ($this->option('testmode')) {
            $value = $this->option('testmode');
            elgg_get_plugin_from_id('wabue')->setSetting('testmode', $value);
            echo "Set testmode to $value";
        } else {
            $value = elgg_get_plugin_setting('testmode', 'wabue');
            echo "Testmode is set to $value";
        }
        return 0;
    }
}

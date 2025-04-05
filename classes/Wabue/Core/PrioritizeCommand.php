<?php

namespace Wabue\Core;

use Elgg\Cli\Command;

class PrioritizeCommand extends Command
{
    protected static $defaultName = 'wabue:prioritize';

    protected function configure(): void
    {
        $this->setDescription('Prioritize the wabue plugin at the last position');
        $this->setHelp('Because we\'re overwriting most stuff here, this plugin needs to be last.');
    }

    protected function command(): int
    {
        if (elgg_is_active_plugin('filetransport')) {
            $filetransport_plugin = elgg_get_plugin_from_id('filetransport');
            $filetransport_plugin->setPriority('last');
        }
        $wabue_plugin = elgg_get_plugin_from_id('wabue');
        $wabue_plugin->setPriority('last');

        return 0;
    }
}

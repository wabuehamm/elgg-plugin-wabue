<?php

namespace Wabue\Core;

class PrioritizeCommand extends \Elgg\Cli\Command {

    protected static $defaultName = 'wabue:prioritize';

    protected function configure() {
        $this->setDescription('Prioritize the wabue plugin at the last position');
        $this->setHelp('Because we\'re overwriting most stuff here, this plugin needs to be last.');
    }

    protected function command() {
        if (elgg_is_active_plugin('filetransport')) {
            $iam = elgg_get_plugin_from_id('filetransport');
            $maxPriority = _elgg_get_max_plugin_priority();

            if ($iam->setPriority($maxPriority) == false) {
                return 1;
            }
        }
        $iam = elgg_get_plugin_from_id('wabue');
        $maxPriority = _elgg_get_max_plugin_priority();

        if ($iam->setPriority($maxPriority) == false) {
            return 1;
        }

        return 0;
    }
}

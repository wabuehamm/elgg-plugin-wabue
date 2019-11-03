<?php

namespace Wabue;

class PrioritizeCommand extends \Elgg\Cli\Command {

    public function __construct() {
        parent::__construct('wabue:prioritize');
        $this->setDescription('Prioritize the wabue plugin at the last position');
    }

    protected function command() {
        $iam = elgg_get_plugin_from_id('wabue');
        $maxPriority = _elgg_get_max_plugin_priority();

        if ($iam->setPriority($maxPriority) == false) {
            return 1;
        }

        return 0;
    }
}
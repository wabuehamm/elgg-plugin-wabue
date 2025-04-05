<?php

namespace Wabue\Core;

use Elgg\Cli\Command;

class ConfigurePluginsCommand extends Command
{

    protected static $defaultName = 'wabue:configure';

    protected function configure(): void
    {
        $this->setDescription('Configure the installed plugins to the default settings');
        $this->setHelp('This command configures several options of the required plugins');
    }

    protected function command(): int
    {
        # Enable polls globally and for forum group
        $poll = elgg_get_plugin_from_id('poll');
        assert(!is_null($poll));
        $poll->setSetting('enable_site', 'yes');
        $poll->setSetting('enable_group', 'yes');

        $forumGroup = get_entity(45105);
        assert($forumGroup instanceof \ElggGroup);
        $forumGroup->enableTool('poll');

        return 0;
    }
}
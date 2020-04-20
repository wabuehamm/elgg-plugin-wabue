<?php

namespace Wabue\Core;

class Commands
{
    public static function registerCommands($hook, $type, $return)
    {
        $return[] = PrioritizeCommand::class;
        $return[] = ConfigurePluginsCommand::class;
        $return[] = AnnouncementCommand::class;
        $return[] = TestModeCommand::class;
        return $return;
    }
}

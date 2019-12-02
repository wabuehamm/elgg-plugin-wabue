<?php

namespace Wabue\Core;

class Commands
{
    public static function registerCommands()
    {
        $return[] = Wabue\PrioritizeCommand::class;
        $return[] = Wabue\ConfigurePluginsCommand::class;
        $return[] = Wabue\AnnouncementCommand::class;
        return $return;
    }
}

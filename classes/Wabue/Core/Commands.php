<?php

namespace Wabue\Core;

class Commands
{
    public static function registerCommands()
    {
        $return[] = Wabue\Core\PrioritizeCommand::class;
        $return[] = Wabue\Core\ConfigurePluginsCommand::class;
        $return[] = Wabue\Core\AnnouncementCommand::class;
        return $return;
    }
}

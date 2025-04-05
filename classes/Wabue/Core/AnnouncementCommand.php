<?php

namespace Wabue\Core;

use Elgg\Cli\Command;
use SiteAnnouncement;
use Symfony\Component\Console\Input\InputArgument;

class AnnouncementCommand extends Command
{
    protected static $defaultName = 'wabue:announcement';

    protected function configure(): void
    {
        $this->setDescription('Set a warning announcement banner');
        $this->setHelp(
            'This command creates a warning announcement using the site_announcements mod e.g. for integration systems'
        );
        $this->addArgument('description', InputArgument::REQUIRED, 'The text of the announcement');
    }

    protected function command(): void
    {
        $entity = new SiteAnnouncement();
        $entity->access_id = ACCESS_PUBLIC;
        $entity->description = $this->argument('description');
        $entity->startdate = time();
        $entity->enddate = time() + 60 * 60 * 48;
        $entity->announcement_type = 'attention';
        $entity->owner_guid = 0;
        $entity->container_guid = 0;
        $entity->save();
    }
}

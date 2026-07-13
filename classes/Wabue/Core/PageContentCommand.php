<?php

namespace Wabue\Core;

use Elgg\Cli\Command;
use Symfony\Component\Console\Input\InputArgument;

class PageContentCommand extends Command
{

    protected static $defaultName = 'wabue:pagecontent';

    protected function configure(): void
    {
        $this->setDescription('Ex- or import set a page content');
        $this->setHelp('This command exports the content of a page or imports it');
        $this->addArgument('mode', InputArgument::REQUIRED, 'The mode to use (export/import)');
        $this->addArgument('id', InputArgument::REQUIRED, 'The entity id of the page to export or import');
    }

    protected function command(): int
    {
        /** @var \ElggPage $page */
        $page = get_entity((int) $this->argument('id'));
        assert(!is_null($page));
        assert($page instanceof \ElggPage);

        assert(in_array($this->argument('mode'), ['export', 'import']));

        if ($this->argument('mode') == 'export'){
            print($page->description);
        } else {
            $content = file_get_contents("php://stdin");
            assert($content != null);
            $page->description = $content;
            $page->save();
        }

        return 0;
    }
}
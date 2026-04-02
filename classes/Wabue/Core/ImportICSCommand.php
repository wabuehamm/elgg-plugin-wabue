<?php

namespace Wabue\Core;

use Elgg\Cli\Command;
use Event;
use Exception;
use Kigkonsult\Icalcreator\IcalInterface;
use Kigkonsult\Icalcreator\Vcalendar;
use Kigkonsult\Icalcreator\Vevent;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Input\InputArgument;


class ImportICSCommand extends Command
{

    protected static $defaultName = 'wabue:importics';

    protected function configure(): void
    {
        $this->setDescription('Import an iCal file into the event manager');
        $this->setHelp('This command loads an ICal file and fills the global event manager calendar with its events');
        $this->addArgument('file', InputArgument::REQUIRED);
    }

    protected function command(): int
    {
        $icsFile = $this->argument('file');
        try {
            $vcalendar = Vcalendar::factory(
                [
                    IcalInterface::UNIQUE_ID => 'https://github.com/ColdTrick/event_manager',
                ]
            );
        } catch (Exception $e) {
            $this->write(
                elgg_echo('event_manager:ical_direct:import:errors:errorinstantiatingcalendar', [$e]),
                'error'
            );
            return 1;
        }

        try {
            $vcalendar->parse(file_get_contents($icsFile));
        } catch (Exception $e) {
            $this->write(
                elgg_echo('event_manager:ical_direct:import:errors:errorpparsingcalendar', [$e]),
                'error'
            );
            return 1;
        }

        $event_counter = 0;

        /** @var Vevent $component */
        foreach ($vcalendar->getComponents('Vevent') as $component) {
            $event = Event::fromVEvent($component);

            $event->save();
            $event_counter++;
        }

        $this->write(elgg_echo('event_manager:ical_direct:import:success', [$event_counter]));

        return 0;
    }
}
<?php

namespace Wabue\Core;

use Elgg\Cli\Command;

class CorrectNotificationsCommand extends Command
{
    protected static $defaultName = 'wabue:correctnotifications';

    protected function configure(): void
    {
        $this->setName(CorrectNotificationsCommand::$defaultName);
        $this->setDescription('Correct the notifications for the Forum group');
    }

    protected function command(): int
    {
        $groups = elgg_get_entities([
            "types" => ["group"],
            "search_name_value_pairs" => [["name" => "name", "value" => "Forum", "operand" => "="]]
        ]);

        if (count($groups) != 1) {
            $this->write(
                'Did not find exactly one Forum group',
                'error'
            );
            return 1;
        }

        $group = $groups[0];

        // @var $rels \ElggRelationship
        $rels = elgg_get_relationships([
            "relationship_guid" => $group->guid,
            "relationship" => "notify:email",
            "inverse_relationship" => true,
            "limit" => 500,
        ]);

        foreach ($rels as $rel) {
            $guid = $rel->guid_two;
            if ($guid == $group->guid) {
                $guid = $rel->guid_one;
            }
            $newrel = new \ElggRelationship();
            $newrel->guid_one = $guid;
            $newrel->guid_two = $group->guid;
            $newrel->relationship = 'notify:object:discussion:create:email';
            $newrel->save();
            $rel->delete();
        }

        return 0;
    }
}

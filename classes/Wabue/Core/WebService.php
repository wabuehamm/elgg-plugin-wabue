<?php

namespace Wabue\Core;

use Elgg\BadRequestException;
use Elgg\Http\Exception\AdminGatekeeperException;
use ElggDiscussion;

require_once(elgg_get_plugins_path(). "/event_calendar/models/model.php");

class WebService
{

    public function addUser($userString)
    {
        if (!elgg_is_admin_logged_in()) {
            throw new AdminGatekeeperException('This request requires an admin');
        }

        $userObject = json_decode($userString);

        $existingUser = get_user_by_username($userObject->username);

        if ($existingUser) {
            $existingUser->delete();
        }

        $userGuid = register_user($userObject->username, $userObject->password, $userObject->name, $userObject->email, true);

        $user = get_user($userGuid);

        $profileFields = [
            'birthday',
            'telephone',
            'street',
            'zip',
            'city',
            'no_mail',
            'member_since',
            'away_years'
        ];

        foreach ($profileFields as $field) {
            $key = "custom_profile_fields[$field]";
            $user->setProfileData($field, $userObject->$key);
        }

        $user->save();

        return $user->guid;
    }

    public function addDiscussion($discussionString)
    {
        if (!elgg_is_admin_logged_in()) {
            throw new AdminGatekeeperException('This request requires an admin');
        }

        $discussionObject = json_decode($discussionString);

        $owner = get_user_by_username($discussionObject->owner_username);

        if (is_null($owner)) {
            throw new BadRequestException("User $discussionObject->owner_username not found.");
        }

        $discussion = new ElggDiscussion();
        $discussion->owner_guid = $owner->guid;
        $discussion->title = $discussionObject->title;
        $discussion->description = $discussionObject->description;
        $discussion->status = $discussionObject->status;
        $discussion->access_id = $discussionObject->access_id;
        $discussion->container_guid = $discussionObject->container_guid;

        $discussion->save();

        return $discussion->guid;
    }

    public function addEvent($eventString)
    {
        if (!elgg_is_admin_logged_in()) {
            throw new AdminGatekeeperException('This request requires an admin');
        }

        $eventObject = json_decode($eventString);

        $owner = get_user_by_username($eventObject->owner_username);

        if (is_null($owner)) {
            throw new BadRequestException("User $eventObject->owner_username not found.");
        }

        foreach ($eventObject as $key => $value) {
            set_input($key, $value);
        }
        $event = event_calendar_set_event_from_form(0, 0);
        $event->owner_guid = $owner->guid;
        $event->save();
        return $event->guid;
    }

    public function register()
    {
        if (elgg_get_plugin_setting('testmode', 'wabue') == 'on') {
            elgg_ws_expose_function(
                'wabue.users.add',
                array($this, 'addUser'),
                [
                    'user' => [
                        'type' => 'string',
                        'required' => true,
                        'description' => 'User object as JSON string'
                    ]
                ],
                'Add a new user to the site',
                'POST',
                false,
                true
            );
            elgg_ws_expose_function(
                'wabue.discussion.add',
                array($this, 'addDiscussion'),
                [
                    'discussion' => [
                        'type' => 'string',
                        'required' => true,
                        'description' => 'Discussion object in json form'
                    ]
                ],
                'Add a new discussion to the site',
                'POST',
                false,
                true
            );
            elgg_ws_expose_function(
                'wabue.event.add',
                array($this, 'addEvent'),
                [
                    'event' => [
                        'type' => 'string',
                        'required' => true,
                        'description' => 'Event object in json form'
                    ]
                ],
                'Add a new event to the site',
                'POST',
                false,
                true
            );
        }
    }
}

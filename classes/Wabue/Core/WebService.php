<?php

namespace Wabue\Core;

use Elgg\Exceptions\Configuration\RegistrationException;
use Elgg\Exceptions\Http\BadRequestException;
use Elgg\Exceptions\Http\Gatekeeper\AdminGatekeeperException;
use ElggDiscussion;

class WebService
{
    /**
     * Adds a new user
     *
     * @throws AdminGatekeeperException if request wasn't send by an admin
     * @throws RegistrationException on a problem with the user registration
     * @noinspection PhpUnused
     */
    public function addUser($userString): int
    {
        if (!elgg_is_admin_logged_in()) {
            throw new AdminGatekeeperException('This request requires an admin');
        }

        $userObject = json_decode($userString);

        $existingUser = elgg_get_user_by_username($userObject->username);

        $existingUser?->delete();

        $user = elgg_register_user([
            "username" => $userObject->username,
            "password" => $userObject->password,
            "name" => $userObject->name,
            "email" => $userObject->email,
            "allow_multiple_emails" => true,
        ]);

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

    /**
     * Create a new discussion
     * @throws BadRequestException If the owner wasn't specified or is wrong
     * @throws AdminGatekeeperException if the request wasn't send by an admin
     * @noinspection PhpUnused
     */
    public function addDiscussion($discussionString): int
    {
        if (!elgg_is_admin_logged_in()) {
            throw new AdminGatekeeperException('This request requires an admin');
        }

        $discussionObject = json_decode($discussionString);

        $owner = elgg_get_user_by_username($discussionObject->owner_username);

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
}

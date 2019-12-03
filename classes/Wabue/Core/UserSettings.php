<?php

namespace Wabue\Core;

use ElggUser;
use Elgg\Request;

class UserSettings
{
    /**
     * overridden hook from user_settings.php#255 because of https://github.com/Elgg/Elgg/issues/12936
     */
    public static function save(\Elgg\Hook $hook)
    {
        $actor = elgg_get_logged_in_user_entity();
        if (!$actor instanceof ElggUser) {
            return null;
        }

        $user = $hook->getUserParam();
        $request = $hook->getParam('request');

        if (!$user instanceof ElggUser || !$request instanceof Request) {
            return null;
        }

        $email = $request->getParam('email');
        if (!isset($email)) {
            return null;
        }

        if (strcmp($email, $user->email) === 0) {
            // no change
            return null;
        }

        try {
            elgg()->accounts->assertValidEmail($email, false);
        } catch (RegistrationException $ex) {
            $request->validation()->fail('email', $email, $ex->getMessage());

            return false;
        }

        if (elgg()->config->security_email_require_password && $user->guid === $actor->guid) {
            try {
                // validate password
                elgg()->accounts->assertCurrentPassword($user, $request->getParam('email_password'));
            } catch (RegistrationException $e) {
                $request->validation()->fail('email', $email, elgg_echo('email:save:fail:password'));
                return false;
            }
        }

        $hook_params = $hook->getParams();
        $hook_params['email'] = $email;

        if (!elgg_trigger_plugin_hook('change:email', 'user', $hook_params, true)) {
            return null;
        }

        if (elgg()->config->security_email_require_confirmation) {
            // validate the new email address
            try {
                elgg()->accounts->requestNewEmailValidation($user, $email);

                $request->validation()->pass('email', $email, elgg_echo('account:email:request:success', [$email]));
                return true;
            } catch (InvalidParameterException $e) {
                $request->validation()->fail('email', $email, elgg_echo('email:save:fail:password'));
                return false;
            }
        }

        $user->email = $email;
        $request->validation()->pass('email', $email, elgg_echo('email:save:success'));
    }
}

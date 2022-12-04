<?php

namespace Wabue\Core;

use Elgg\HttpException;
use Elgg\Request;
use ElggUser;

/**
 * Class ReportGatekeeper
 *
 * The report gatekeeper does intense ACL checkings for showing the available reports.
 */
class AppointmentGatekeeper
{

    /**
     * Check wether the request is allowed
     *
     * @param Request $request Request
     *
     * @return void
     * @throws HttpException
     */
    public function __invoke(Request $request)
    {
        /** @var $user ElggUser **/
        $user = elgg_get_logged_in_user_entity();
        $appointment_users = preg_split("/\r?\n/", elgg_get_plugin_setting('appointment_users', 'wabue'));
        if (!in_array($user->username, $appointment_users)) {
            throw new HttpException(elgg_echo('wabue:appointments:gatekeeper:error'), 403);
        }
    }

}

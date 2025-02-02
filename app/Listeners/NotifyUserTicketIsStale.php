<?php
/**
 * NOTICE OF LICENSE.
 *
 * UNIT3D Community Edition is open-sourced software licensed under the GNU Affero General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D Community Edition
 *
 * @author     HDVinnie <hdinnovations@protonmail.com>
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 */

namespace App\Listeners;

use App\Events\TicketWentStale;
use App\Notifications\UserTicketStale;

use function time;

class NotifyUserTicketIsStale
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(TicketWentStale $event): void
    {
        $event->ticket->user->notify(new UserTicketStale($event->ticket));
        $event->ticket->update(['reminded_at' => time()]);
    }
}

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

namespace App\Notifications;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

use function sprintf;

class NewFollow extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * NewFollow Constructor.
     */
    public function __construct(public string $type, public User $sender, public User $target, public Follow $follow)
    {
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'title' => $this->sender->username.' Has Followed You!',
            'body'  => $this->sender->username.' has started to follow you so they will get notifications about your activities.',
            'url'   => sprintf('/users/%s', $this->sender->username),
        ];
    }
}

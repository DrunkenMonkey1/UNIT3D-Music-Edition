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

use App\Models\TorrentRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

use function sprintf;

class NewRequestBounty extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * NewRequestBounty Constructor.
     */
    public function __construct(public string $type, public string $sender, public $amount, public TorrentRequest $torrentRequest)
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
            'title' => $this->sender.' Has Added A Bounty Of '.$this->amount.' To A Requested Torrent',
            'body'  => $this->sender.' has added a bounty to one of your Requested Torrents '.$this->torrentRequest->name,
            'url'   => sprintf('/requests/%s', $this->torrentRequest->id),
        ];
    }
}

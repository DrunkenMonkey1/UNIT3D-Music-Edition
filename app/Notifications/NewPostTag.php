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

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

use function sprintf;

class NewPostTag extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * NewPostTag Constructor.
     */
    public function __construct(public string $type, public string $tagger, public Post $post)
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
            'title' => $this->tagger.' Has Tagged You In A Post',
            'body'  => $this->tagger.' has tagged you in a Post in Topic '.$this->post->topic->name,
            'url'   => sprintf('/forums/topics/%s?page=%s#post-%s', $this->post->topic->id, $this->post->getPageNumber(), $this->post->id),
        ];
    }
}

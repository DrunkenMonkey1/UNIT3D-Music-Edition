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

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use function route;
use function trans;
use function config;

class UsernameReminder extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * UsernameReminderEmail constructor.
     */
    public function __construct()
    {
        // nothing special to do
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
                    ->subject(trans('common.your').' '.config('app.name').' '.trans('common.username'))
                    ->greeting(trans('common.contact-header').', '.$notifiable->username)
                    ->line(trans('email.username-reminder').' '.$notifiable->username)
                    ->action('Login as '.$notifiable->username, route('login'))
                    ->line(trans('email.thanks').' '.config('app.name'));
    }
}

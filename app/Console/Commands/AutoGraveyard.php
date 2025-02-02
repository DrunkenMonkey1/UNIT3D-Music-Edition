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

namespace App\Console\Commands;

use App\Models\Graveyard;
use App\Models\History;
use App\Models\PrivateMessage;
use App\Models\Torrent;
use App\Models\User;
use App\Repositories\ChatRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

use function config;
use function href_torrent;
use function sprintf;

/**
 * @see \Tests\Unit\Console\Commands\AutoGraveyardTest
 */
class AutoGraveyard extends Command
{
    /**
     * AutoGraveyards Constructor.
     */
    public function __construct(private readonly ChatRepository $chatRepository)
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:graveyard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically Checks Graveyard Records For Succesful Ressurections';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        foreach (Graveyard::where('rewarded', '!=', 1)->oldest()->get() as $reward) {
            $user = User::where('id', '=', $reward->user_id)->first();

            $torrent = Torrent::where('id', '=', $reward->torrent_id)->first();

            if (isset($user, $torrent)) {
                $history = History::where('torrent_id', '=', $torrent->id)
                    ->where('user_id', '=', $user->id)
                    ->where('seedtime', '>=', $reward->seedtime)
                    ->first();
            }

            if (isset($history)) {
                $reward->rewarded = 1;
                $reward->save();

                $user->fl_tokens += config('graveyard.reward');
                $user->save();

                // Auto Shout
                $appurl = config('app.url');

                $this->chatRepository->systemMessage(
                    sprintf('Ladies and Gents, [url=%s/users/%s]%s[/url] has successfully resurrected [url=%s/torrents/%s]%s[/url]. :zombie:', $appurl, $user->username, $user->username, $appurl, $torrent->id, $torrent->name)
                );

                // Bump Torrent With FL
                $torrentUrl         = href_torrent($torrent);
                $torrent->bumped_at = Carbon::now();
                $torrent->free      = 100;
                $torrent->fl_until  = Carbon::now()->addDays(3);
                $this->chatRepository->systemMessage(
                    sprintf('Ladies and Gents, [url=%s]%s[/url] has been granted 100%% FreeLeech for 3 days and has been bumped to the top. :stopwatch:', $torrentUrl, $torrent->name)
                );
                $torrent->save();

                // Send Private Message
                $pm              = new PrivateMessage();
                $pm->sender_id   = 1;
                $pm->receiver_id = $user->id;
                $pm->subject     = 'Successful Graveyard Resurrection';
                $pm->message     = sprintf('You have successfully resurrected [url=%s/torrents/', $appurl).$torrent->id.']'.$torrent->name.'[/url] :zombie: ! Thank you for bringing a torrent back from the dead! Enjoy the freeleech tokens!
                [color=red][b]THIS IS AN AUTOMATED SYSTEM MESSAGE, PLEASE DO NOT REPLY![/b][/color]';
                $pm->save();
            }
        }

        $this->comment('Automated Graveyard Rewards Command Complete');
    }
}

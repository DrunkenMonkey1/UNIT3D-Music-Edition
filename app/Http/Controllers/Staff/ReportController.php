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

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\PrivateMessage;
use App\Models\Report;
use Illuminate\Http\Request;

use function preg_match_all;
use function view;
use function auth;
use function validator;
use function sprintf;
use function to_route;

/**
 * @see \Tests\Todo\Feature\Http\Controllers\ReportControllerTest
 */
class ReportController extends Controller
{
    /**
     * Display All Reports.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $reports = Report::orderBy('solved')->latest()->paginate(25);

        return view('Staff.report.index', ['reports' => $reports]);
    }

    /**
     * Show A Report.
     */
    public function show(int $id): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $report = Report::findOrFail($id);

        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', (string) $report->message, $match);

        return view('Staff.report.show', ['report' => $report, 'urls' => $match[0]]);
    }

    /**
     * Update A Report.
     */
    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $user = auth()->user();

        $report = Report::findOrFail($id);
        if ($report->solved == 1) {
            return to_route('staff.reports.index')
                ->withErrors('This Report Has Already Been Solved');
        }

        $report->verdict  = $request->input('verdict');
        $report->staff_id = $user->id;
        $report->solved   = 1;

        $v = validator($report->toArray(), [
            'verdict'  => 'required|min:3',
            'staff_id' => 'required',
        ]);

        if ($v->fails()) {
            return to_route('staff.reports.show', ['id' => $report->id])
                ->withErrors($v->errors());
        }

        $report->save();

        // Send Private Message
        $privateMessage              = new PrivateMessage();
        $privateMessage->sender_id   = $user->id;
        $privateMessage->receiver_id = $report->reporter_id;
        $privateMessage->subject     = 'Your Report Has A New Verdict';
        $privateMessage->message     = sprintf('[b]REPORT TITLE:[/b] %s

                        [b]ORIGINAL MESSAGE:[/b] %s

                        [b]VERDICT:[/b] %s', $report->title, $report->message, $report->verdict);
        $privateMessage->save();

        return to_route('staff.reports.index')
            ->withSuccess('Report has been successfully resolved');
    }
}

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

namespace App\Http\Livewire;

use App\Models\PersonalFreeleech;
use App\Models\Torrent;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

use function strlen;
use function preg_match;
use function array_map;
use function view;
use function auth;

class TorrentListSearch extends Component
{
    use WithPagination;

    public string $name = '';

    public string $description = '';

    public string $uploader = '';

    public string $keywords = '';

    public string $startYear = '';

    public string $endYear = '';

    public array $categories = [];


    public array $genres = [];

    public string $playlistId = '';

    public string $collectionId = '';

    public array $free = [];

    public bool $doubleup = false;

    public bool $featured = false;

    public bool $stream = false;

    public bool $highspeed = false;

    public bool $bookmarked = false;

    public bool $wished = false;

    public bool $internal = false;

    public bool $personalRelease = false;

    public bool $alive = false;

    public bool $dying = false;

    public bool $dead = false;

    public bool $notDownloaded = false;

    public bool $downloaded = false;

    public bool $seeding = false;

    public bool $leeching = false;

    public bool $incomplete = false;

    public int $perPage = 25;

    public string $sortField = 'bumped_at';

    public string $sortDirection = 'desc';

    protected $queryString = [
        'name'             => ['except' => ''],
        'description'      => ['except' => ''],
        'uploader'         => ['except' => ''],
        'keywords'         => ['except' => ''],
        'startYear'        => ['except' => ''],
        'endYear'          => ['except' => ''],
        'categories'       => ['except' => []],
        'genres'           => ['except' => []],
        'playlistId'       => ['except' => ''],
        'collectionId'     => ['except' => ''],
        'free'             => ['except' => []],
        'doubleup'         => ['except' => false],
        'featured'         => ['except' => false],
        'stream'           => ['except' => false],
        'highspeed'        => ['except' => false],
        'bookmarked'       => ['except' => false],
        'wished'           => ['except' => false],
        'internal'         => ['except' => false],
        'personalRelease'  => ['except' => false],
        'alive'            => ['except' => false],
        'dying'            => ['except' => false],
        'dead'             => ['except' => false],
        'downloaded'       => ['except' => false],
        'seeding'          => ['except' => false],
        'leeching'         => ['except' => false],
        'incomplete'       => ['except' => false],
        'sortField'        => ['except' => 'bumped_at'],
        'sortDirection'    => ['except' => 'desc'],
        'page'             => ['except' => 1],
        'perPage'          => ['except' => ''],
    ];

    protected array $rules = [
        'genres.*' => 'exists:genres,id',
    ];

    final public function paginationView(): string
    {
        return 'vendor.pagination.livewire-pagination';
    }

    final public function updatedPage(): void
    {
        $this->emit('paginationChanged');
    }

    final public function updatingName(): void
    {
        $this->resetPage();
    }

    final public function getTorrentsStatProperty(): ?object
    {
        return DB::table('torrents')
            ->selectRaw('count(*) as total')
            ->selectRaw('count(case when seeders > 0 then 1 end) as alive')
            ->selectRaw('count(case when seeders = 0 then 1 end) as dead')
            ->first();
    }

    final public function getPersonalFreeleechProperty()
    {
        return PersonalFreeleech::where('user_id', '=', auth()->user()->id)->first();
    }

    final public function getTorrentsProperty(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $user           = auth()->user();
        $isRegexAllowed = $user->group->is_modo;
        $isRegex        = fn ($field) => $isRegexAllowed
            && strlen($field) > 2
            && $field[0]  === '/'
            && $field[-1] === '/'
            && @preg_match($field, 'Validate regex') !== false;

        return Torrent::with(['user:id,username,group_id', 'user.group', 'category'])
            ->withCount(['thanks', 'comments'])
            ->when($this->name !== '', fn ($query) => $query->ofName($this->name, $isRegex($this->name)))
            ->when($this->description !== '', fn ($query) => $query->ofDescription($this->description, $isRegex($this->description)))
            ->when($this->uploader !== '', fn ($query) => $query->ofUploader($this->uploader))
            ->when($this->keywords !== '', fn ($query) => $query->ofKeyword(array_map('trim', explode(',', $this->keywords))))
            ->when($this->startYear !== '', fn ($query) => $query->releasedAfterOrIn((int) $this->startYear))
            ->when($this->endYear !== '', fn ($query) => $query->releasedBeforeOrIn((int) $this->endYear))
            ->when($this->categories !== [], fn ($query) => $query->ofCategory($this->categories))
            ->when($this->genres !== [], fn ($query) => $query->ofGenre($this->genres))
            ->when($this->playlistId !== '', fn ($query) => $query->ofPlaylist((int) $this->playlistId))
            ->when($this->collectionId !== '', fn ($query) => $query->ofCollection((int) $this->collectionId))
            ->when($this->free !== [], fn ($query) => $query->ofFreeleech($this->free))
            ->when($this->doubleup !== false, fn ($query) => $query->doubleup())
            ->when($this->featured !== false, fn ($query) => $query->featured())
            ->when($this->stream !== false, fn ($query) => $query->streamOptimized())
            ->when($this->highspeed !== false, fn ($query) => $query->highspeed())
            ->when($this->bookmarked !== false, fn ($query) => $query->bookmarkedBy($user))
            ->when($this->wished !== false, fn ($query) => $query->wishedBy($user))
            ->when($this->internal !== false, fn ($query) => $query->internal())
            ->when($this->personalRelease !== false, fn ($query) => $query->personalRelease())
            ->when($this->alive !== false, fn ($query) => $query->alive())
            ->when($this->dying !== false, fn ($query) => $query->dying())
            ->when($this->dead !== false, fn ($query) => $query->dead())
            ->when($this->notDownloaded !== false, fn ($query) => $query->notDownloadedBy($user))
            ->when($this->downloaded !== false, fn ($query) => $query->downloadedBy($user))
            ->when($this->seeding !== false, fn ($query) => $query->seededBy($user))
            ->when($this->leeching !== false, fn ($query) => $query->leechedBy($user))
            ->when($this->incomplete !== false, fn ($query) => $query->uncompletedBy($user))
            ->latest('sticky')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    final public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    final public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.torrent-list-search', [
            'user'              => User::with(['group'])->findOrFail(auth()->user()->id),
            'torrents'          => $this->torrents,
            'torrentsStat'      => $this->torrentsStat,
            'personalFreeleech' => $this->personalFreeleech,
        ]);
    }
}

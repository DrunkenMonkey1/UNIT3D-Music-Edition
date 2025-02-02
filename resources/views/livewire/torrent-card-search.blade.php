<div>
    <div class="container-fluid">
        <style>
            .form-group {
                margin-bottom: 5px !important;
            }

            .badge-extra {
                margin-bottom: 0;
            }
        </style>
        <div x-data="{ open: false }" class="container box" id="torrent-list-search"
             style="margin-bottom: 0; padding: 10px 100px; border-radius: 5px;">
            <div class="mt-5">
                <div class="row">
                    <div class="form-group col-xs-9">
                        <input wire:model="name" type="search" class="form-control" placeholder="Name"/>
                    </div>
                    <div class="form-group col-xs-3">
                        <button class="btn btn-md btn-primary" @click="open = ! open"
                                x-text="open ? '{{ __('common.search-hide') }}' : '{{ __('common.search-advanced') }}'"></button>
                    </div>
                </div>
                <div x-cloak x-show="open" id="torrent-advanced-search">
                    <div class="row">
                        <div class="form-group col-sm-3 col-xs-6 adv-search-description">
                            <label for="description" class="label label-default">{{ __('torrent.description') }}</label>
                            <input wire:model="description" type="text" class="form-control" placeholder="Description">
                        </div>
                        <div class="form-group col-sm-3 col-xs-6 adv-search-keywords">
                            <label for="keywords" class="label label-default">{{ __('torrent.keywords') }}</label>
                            <input wire:model="keywords" type="text" class="form-control" placeholder="Keywords">
                        </div>
                        <div class="form-group col-sm-3 col-xs-6 adv-search-uploader">
                            <label for="uploader" class="label label-default">{{ __('torrent.uploader') }}</label>
                            <input wire:model="uploader" type="text" class="form-control" placeholder="Uploader">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-3 col-xs-6 adv-search-startYear">
                            <label for="startYear" class="label label-default">{{ __('torrent.start-year') }}</label>
                            <input wire:model="startYear" type="text" class="form-control" placeholder="Start Year">
                        </div>
                        <div class="form-group col-sm-3 col-xs-6 adv-search-endYear">
                            <label for="endYear" class="label label-default">{{ __('torrent.end-year') }}</label>
                            <input wire:model="endYear" type="text" class="form-control" placeholder="End Year">
                        </div>
                        <div class="form-group col-sm-3 col-xs-6 adv-search-playlist">
                            <label for="playlist" class="label label-default">Playlist</label>
                            <input wire:model="playlistId" type="text" class="form-control" placeholder="Playlist ID">
                        </div>
                        <div class="form-group col-sm-3 col-xs-6 adv-search-collection">
                            <label for="collection" class="label label-default">Collection</label>
                            <input wire:model="collectionId" type="text" class="form-control"
                                   placeholder="Collection ID">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-6 adv-search-categories">
                            <label for="categories" class="label label-default">{{ __('common.category') }}</label>
                            @php $categories = cache()->remember('categories', 3_600, fn () => App\Models\Category::all()->sortBy('position')) @endphp
                            @foreach ($categories as $category)
                                <span class="badge-user">
									<label class="inline">
										<input type="checkbox" wire:model="categories" value="{{ $category->id }}"> {{ $category->name }}
									</label>
								</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-6 adv-search-genres">
                            <label for="genres" class="label label-default">{{ __('common.genre') }}</label>
                            @foreach (App\Models\Genre::all()->sortBy('name') as $genre)
                                <span class="badge-user">
									<label class="inline">
										<input type="checkbox" wire:model="genres" value="{{ $genre->id }}"> {{ $genre->name }}
									</label>
								</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-6 adv-search-buffs">
                            <label for="buffs" class="label label-default">Buff</label>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="free" type="checkbox" value="0">
									0% Freeleech
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="free" type="checkbox" value="25">
									25% Freeleech
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="free" type="checkbox" value="50">
									50% Freeleech
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="free" type="checkbox" value="75">
									75% Freeleech
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="free" type="checkbox" value="100">
									100% Freeleech
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model="doubleup" type="checkbox" value="1">
									Double Upload
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model="featured" type="checkbox" value="1">
									Featured
								</label>
							</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-6 adv-search-tags">
                            <label for="tags" class="label label-default">Tags</label>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model="stream" type="checkbox" value="1">
									Stream Optimized
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model="sd" type="checkbox" value="1">
									SD Content
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model="highspeed" type="checkbox" value="1">
									Highspeed
								</label>
							</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-6 adv-search-extra">
                            <label for="extra" class="label label-default">{{ __('common.extra') }}</label>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model="internal" type="checkbox" value="1">
									Internal
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model="personalRelease" type="checkbox" value="1">
									Personal Release
								</label>
							</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-6 adv-search-misc">
                            <label for="misc" class="label label-default">Misc</label>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model="bookmarked" type="checkbox" value="1">
									Bookmarked
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model="wished" type="checkbox" value="1">
									Wished
								</label>
							</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-6 adv-search-health">
                            <label for="health" class="label label-default">{{ __('torrent.health') }}</label>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model="alive" type="checkbox" value="1">
									{{ __('torrent.alive') }}
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model="dying" type="checkbox" value="1">
									{{ __('torrent.dying-torrent') }}
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model="dead" type="checkbox" value="1">
									{{ __('torrent.dead-torrent') }}
								</label>
							</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-6 adv-search-history">
                            <label for="history" class="label label-default">{{ __('torrent.history') }}</label>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model="notDownloaded" type="checkbox" value="1">
									Not Downloaded
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model="downloaded" type="checkbox" value="1">
									Downloaded
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model="seeding" type="checkbox" value="1">
									Seeding
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model="leeching" type="checkbox" value="1">
									Leeching
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model="incomplete" type="checkbox" value="1">
									Incomplete
								</label>
							</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-6 adv-search-quantity">
                            <label for="quantity" class="label label-default">{{ __('common.quantity') }}</label>
                            <span>
								<label class="inline">
								<select wire:model="perPage" class="form-control">
									<option value="25">24</option>
									<option value="50">48</option>
									<option value="100">72</option>
								</select>
								</label>
							</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <br>
    <div class="text-center">
        {{ $torrents->links() }}
    </div>
    <br>
    <div class="table-responsive block">
        <span class="badge-user torrent-listings-stats" style="float: right;">
            <strong>Total:</strong> {{ number_format($torrentsStat->total) }} |
            <strong>Alive:</strong> {{ number_format($torrentsStat->alive) }} |
            <strong>Dead:</strong> {{ number_format($torrentsStat->dead) }}
        </span>
        <table class="table table-condensed table-striped table-bordered" id="torrent-list-table">
            <thead>
            <tr>
                <th class="torrent-listings-poster"></th>
                <th class="torrent-listings-format"></th>
                <th class="torrents-filename torrent-listings-overview">
                    <div sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null"
                         role="button">
                        {{ __('common.name') }}
                        @include('livewire.includes._sort-icon', ['field' => 'name'])
                    </div>
                </th>
                <th class="torrent-listings-download">
                    <div>
                        <i class="{{ config('other.font-awesome') }} fa-download"></i>
                    </div>
                </th>
                <th class="torrent-listings-tmdb">
                    <div>
                        <i class="{{ config('other.font-awesome') }} fa-id-badge"></i>
                    </div>
                </th>
                <th class="torrent-listings-size">
                    <div sortable wire:click="sortBy('size')" :direction="$sortField === 'size' ? $sortDirection : null"
                         role="button">
                        <i class="{{ config('other.font-awesome') }} fa-database"></i>
                        @include('livewire.includes._sort-icon', ['field' => 'size'])
                    </div>
                </th>
                <th class="torrent-listings-seeders">
                    <div sortable wire:click="sortBy('seeders')"
                         :direction="$sortField === 'seeders' ? $sortDirection : null" role="button">
                        <i class="{{ config('other.font-awesome') }} fa-arrow-alt-circle-up"></i>
                        @include('livewire.includes._sort-icon', ['field' => 'seeders'])
                    </div>
                </th>
                <th class="torrent-listings-leechers">
                    <div sortable wire:click="sortBy('leechers')"
                         :direction="$sortField === 'leechers' ? $sortDirection : null" role="button">
                        <i class="{{ config('other.font-awesome') }} fa-arrow-alt-circle-down"></i>
                        @include('livewire.includes._sort-icon', ['field' => 'leechers'])
                    </div>
                </th>
                <th class="torrent-listings-completed">
                    <div sortable wire:click="sortBy('times_completed')"
                         :direction="$sortField === 'times_completed' ? $sortDirection : null" role="button">
                        <i class="{{ config('other.font-awesome') }} fa-check-circle"></i>
                        @include('livewire.includes._sort-icon', ['field' => 'times_completed'])
                    </div>
                </th>
                <th class="torrent-listings-age">
                    <div sortable wire:click="sortBy('created_at')"
                         :direction="$sortField === 'created_at' ? $sortDirection : null" role="button">
                        {{ __('common.created_at') }}
                        @include('livewire.includes._sort-icon', ['field' => 'created_at'])
                    </div>
                </th>
            </tr>
            </thead>
        </table>
        @foreach($torrents as $torrent)
            @php $meta = null @endphp

            <div class="col-md-4">
                <div class="card is-torrent">
                    <div class="card_head">
							<span class="badge-user text-bold" style="float:right;">
								<i class="{{ config('other.font-awesome') }} fa-fw fa-arrow-up text-green"></i>
								{{ $torrent->seeders }} /
								<i class="{{ config('other.font-awesome') }} fa-fw fa-arrow-down text-red"></i>
								{{ $torrent->leechers }} /
								<i class="{{ config('other.font-awesome') }} fa-fw fa-check text-orange"></i>
								{{ $torrent->times_completed }}
							</span>&nbsp;
                        <span class="badge-user text-bold text-blue" style="float:right;">
								{{ $torrent->getSize() }}
							</span>&nbsp;
                        <span class="badge-user text-bold text-blue" style="float:right;">
								{{ $torrent->type->name }}
							</span>&nbsp;
                        <span class="badge-user text-bold text-blue" style="float:right;">
								{{ $torrent->category->name }}
							</span>&nbsp;
                    </div>
                    <div class="card_body">
                        <div class="body_poster">

                            @if ($torrent->category->music_meta)
                                <img src="https://via.placeholder.com/200x300"
                                     data-name='<i style="color: #a5a5a5;">N/A</i>'
                                     data-image='<img src="https://via.placeholder.com/200x300"
									     alt="{{ __('torrent.poster') }}" style="height: 1000px;">'
                                     class="torrent-poster-img-small show-poster" alt="{{ __('torrent.poster') }}">
                            @endif

                            @if ($torrent->category->no_meta)
                                @if(file_exists(public_path().'/files/img/torrent-cover_'.$torrent->id.'.jpg'))
                                    <img src="{{ url('files/img/torrent-cover_' . $torrent->id . '.jpg') }}"
                                         class="show-poster" alt="{{ __('torrent.poster') }}">
                                @else
                                    <img src="https://via.placeholder.com/200x300" class="show-poster"
                                         data-name='<i style="color: #a5a5a5;">N/A</i>'
                                         data-image='<img src="https://via.placeholder.com/200x300" alt="{{ __('torrent.poster') }}" style="height: 1000px;">'
                                         class="torrent-poster-img-small show-poster" alt="{{ __('torrent.poster') }}">
                                @endif
                            @endif
                        </div>
                        <div class="body_description">
                            <h3 class="description_title">
                                <a href="{{ route('torrent', ['id' => $torrent->id]) }}">
                                    {{ $torrent->name }}
                                </a>
                            </h3>

                        </div>
                    </div>
                    <div class="card_footer">
                        <div style="float: left;">
                            @if ($torrent->anon == 1)
                                <span class="badge-user text-orange text-bold">{{ strtoupper(__('common.anonymous')) }}
                                    @if ($user->id === $torrent->user->id || $user->group->is_modo)
                                        <a href="{{ route('users.show', ['username' => $torrent->user->username]) }}">
												({{ $torrent->user->username }})
											</a>
                                    @endif
									</span>
                            @else
                                <a href="{{ route('users.show', ['username' => $torrent->user->username]) }}">
										<span class="badge-user text-bold"
                                              style="color:{{ $torrent->user->group->color }}; background-image:{{ $torrent->user->group->effect }};">
											<i class="{{ $torrent->user->group->icon }}" data-toggle="tooltip"
                                               data-original-title="{{ $torrent->user->group->name }}"></i>
											{{ $torrent->user->username }}
										</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @if (! $torrents->count())
            <div class="margin-10 torrent-listings-no-result">
                {{ __('common.no-result') }}
            </div>
        @endif
        <br>
        <div class="text-center torrent-listings-pagination">
            {{ $torrents->links() }}
        </div>
        <br>
        <div class="container-fluid well torrent-listings-legend">
            <div class="text-center">
                <strong>{{ __('common.legend') }}:</strong>
                <button class='btn btn-success btn-circle torrent-listings-seeding' type='button' data-toggle='tooltip'
                        title=''
                        data-original-title='{{ __('torrent.currently-seeding') }}!'>
                    <i class='{{ config('other.font-awesome') }} fa-arrow-up'></i>
                </button>
                <button class='btn btn-warning btn-circle torrent-listings-leeching' type='button' data-toggle='tooltip'
                        title=''
                        data-original-title='{{ __('torrent.currently-leeching') }}!'>
                    <i class='{{ config('other.font-awesome') }} fa-arrow-down'></i>
                </button>
                <button class='btn btn-info btn-circle torrent-listings-incomplete' type='button' data-toggle='tooltip'
                        title=''
                        data-original-title='{{ __('torrent.not-completed') }}!'>
                    <i class='{{ config('other.font-awesome') }} fa-spinner'></i>
                </button>
                <button class='btn btn-danger btn-circle torrent-listings-complete' type='button' data-toggle='tooltip'
                        title=''
                        data-original-title='{{ __('torrent.completed-not-seeding') }}!'>
                    <i class='{{ config('other.font-awesome') }} fa-thumbs-down'></i>
                </button>
            </div>
        </div>
    </div>
</div>

@extends('layout.default')

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('torrents') }}" class="breadcrumb__link">
            {{ __('torrent.torrents') }}
        </a>
    </li>
    <li class="breadcrumbV2">
        <a href="{{ route('torrent', ['id' => $torrent->id]) }}" class="breadcrumb__link">
            {{ $torrent->name }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ __('common.edit') }}
    </li>
@endsection

@section('content')
    <div class="container">
        <div class="col-md-10">
            <h2>{{ __('common.edit') }}: {{ $torrent->name }}</h2>
            <div class="block">
                <form role="form" method="POST" action="{{ route('edit', ['id' => $torrent->id]) }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">{{ __('torrent.title') }}</label>
                        <label>
                            <input type="text" class="form-control" name="name" value="{{ $torrent->name }}" required>
                        </label>
                    </div>

                    @if ($torrent->category->no_meta)
                        <div class="form-group">
                            <label for="torrent-cover">Cover {{ __('torrent.file') }} ({{ __('torrent.optional') }})</label>
                            <input class="upload-form-file" type="file" accept=".jpg, .jpeg, .png" name="torrent-cover">
                        </div>
                        <div class="form-group">
                            <label for="torrent-banner">Banner {{ __('torrent.file') }} ({{ __('torrent.optional') }})</label>
                            <input class="upload-form-file" type="file" accept=".jpg, .jpeg, .png"
                                   name="torrent-banner">
                        </div>
                    @endif


                    <div class="form-group">
                        <label for="name">{{ __('torrent.keywords') }} (<i>{{ __('torrent.keywords-example') }}</i>)</label>
                        <label>
                            <input type="text" name="keywords" value="{{ $keywords->implode(', ') }}" class="form-control">
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="category_id">{{ __('torrent.category') }}</label>
                        <label>
                            <select name="category_id" class="form-control">
                                <option value="{{ $torrent->category->id }}" selected>{{ $torrent->category->name }}
                                    ({{ __('torrent.current') }})
                                </option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="type">{{ __('torrent.type') }}</label>
                        <label>
                            <select name="type_id" class="form-control">
                                <option value="{{ $torrent->type->id }}" selected>{{ $torrent->type->name }}
                                    ({{ __('torrent.current') }})
                                </option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>


                    <div class="form-group">
                        <label for="description">{{ __('common.description') }}</label>
                        <label for="upload-form-description"></label>
                        <textarea id="editor" name="description" cols="30" rows="10"
                                  class="form-control">{{ $torrent->description }}</textarea>
                    </div>

                    @if (auth()->user()->group->is_modo || auth()->user()->id === $torrent->user_id)
                        <label for="hidden" class="control-label">{{ __('common.anonymous') }}?</label>
                        <div class="radio-inline">
                            <label><input type="radio" name="anonymous" @if ($torrent->anon == 1) checked
                                          @endif value="1">{{ __('common.yes') }}</label>
                        </div>
                        <div class="radio-inline">
                            <label><input type="radio" name="anonymous" @if ($torrent->anon == 0) checked
                                          @endif value="0">{{ __('common.no') }}</label>
                        </div>
                        <br>
                        <br>
                    @else
                        <input type="hidden" name="anonymous" value={{ $torrent->anon }}>
                    @endif
                    <label for="hidden" class="control-label">{{ __('torrent.stream-optimized') }}?</label>
                    <div class="radio-inline">
                        <label><input type="radio" name="stream" @if ($torrent->stream == 1) checked
                                      @endif value="1">{{ __('common.yes') }}</label>
                    </div>
                    <div class="radio-inline">
                        <label><input type="radio" name="stream" @if ($torrent->stream == 0) checked
                                      @endif value="0">{{ __('common.no') }}</label>
                    </div>
                    <br>
                    <br>
                    @if (auth()->user()->group->is_modo || auth()->user()->group->is_internal)
                        <label for="internal" class="control-label">Internal?</label>
                        <div class="radio-inline">
                            <label><input type="radio" name="internal" @if ($torrent->internal == 1) checked
                                          @endif value="1">{{ __('common.yes') }}</label>
                        </div>
                        <div class="radio-inline">
                            <label><input type="radio" name="internal" @if ($torrent->internal == 0) checked
                                          @endif value="0">{{ __('common.no') }}</label>
                        </div>
                        <br>
                        <br>
                    @else
                        <input type="hidden" name="internal" value="{{ $torrent->internal }}">
                    @endif
                    @if (auth()->user()->group->is_modo || auth()->user()->id === $torrent->user_id)
                        <label for="personal" class="control-label">Personal Release?</label>
                        <div class="radio-inline">
                            <label><input type="radio" name="personal_release"
                                          @if ($torrent->personal_release == 1) checked
                                          @endif value="1">{{ __('common.yes') }}</label>
                        </div>
                        <div class="radio-inline">
                            <label><input type="radio" name="personal_release"
                                          @if ($torrent->personal_release == 0) checked
                                          @endif value="0">{{ __('common.no') }}</label>
                        </div>
                    @else
                        <input type="hidden" name="personal_release" value="{{ $torrent->personal_release }}">
                    @endif
                    <br>
                    <br>
                    <button type="submit" class="btn btn-primary">{{ __('common.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

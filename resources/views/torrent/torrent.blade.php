@extends('layout.default')

@section('title')
    <title>{{ $torrent->name }} - {{ __('torrent.torrents') }} - {{ config('other.title') }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ __('torrent.meta-desc', ['name' => $torrent->name]) }}!">
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('torrents') }}" class="breadcrumb__link">
            {{ __('torrent.torrents') }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ $torrent->name }}
    </li>
@endsection

@section('content')
    <div id="torrent-page">
        <div class="meta-wrapper box container" id="meta-info">
            {{-- No Meta Block --}}
                @include('torrent.partials.no_meta')

            <div style="padding: 10px; position: relative;">
                <div class="vibrant-overlay"></div>
                <div class="button-overlay"></div>
            </div>
            <h1 class="text-center" style="font-size: 22px; margin: 12px 0 0 0;">
                {{ $torrent->name }}
            </h1>
            <div class="torrent-buttons">
                @include('torrent.partials.buttons')
            </div>
        </div>
        <div class="meta-general box container">
            {{-- General Info Block --}}
            @include('torrent.partials.general')

            {{-- Tools Block --}}
            @if (auth()->user()->group->is_modo || auth()->user()->id === $uploader->id || auth()->user()->group->is_internal)
                @include('torrent.partials.tools')
            @endif

            {{-- Audits Block --}}
            @if (auth()->user()->group->is_modo)
                @include('torrent.partials.audits')
                @include('torrent.partials.downloads')
            @endif

            {{-- Description Block --}}
            @include('torrent.partials.description')


            {{-- TipJar Block --}}
            @include('torrent.partials.tipjar')

            {{-- Extra Meta Block --}}
            @include('torrent.partials.extra_meta')
        </div>

        <div class="torrent box container" id="comments">
            {{-- Commments Block --}}
            @include('torrent.partials.comments')
        </div>

        {{-- Modals Block --}}
        @include('torrent.torrent_modals', ['user' => $user, 'torrent' => $torrent])
    </div>
@endsection

@section('javascripts')
    <script nonce="{{ HDVinnie\SecureHeaders\SecureHeaders::nonce() }}">
      $('.torrent-freeleech-token').on('click', function (event) {
        event.preventDefault();
        let form = $(this).parents('form');
        Swal.fire({
          title: 'Are you sure?',
          text: 'This will use one of your Freeleech Tokens!',
          icon: 'warning',
          showConfirmButton: true,
          showCloseButton: true,
        }).then((result) => {
          if (result.isConfirmed && {{ $torrent->seeders }} == 0) {
            Swal.fire({
              title: 'Are you sure?',
              text: 'This torrent has 0 seeders!',
              icon: 'warning',
              showConfirmButton: true,
              showCancelButton: true,
            }).then((result) => {
              if (result.isConfirmed) {
                form.submit();
              }
            });
          } else if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    </script>
@endsection

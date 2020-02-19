@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  <div class="container">
    <div class="row">
      <div class="col-12">

        @if (!have_posts())
          <div class="alert alert-warning">
            {{ __('Sorry, but the page you were trying to view does not exist.', 'fewbricks2-demo-theme') }}
          </div>
          {!! get_search_form(false) !!}
        @endif

      </div>
    </div>
  </div>
@endsection

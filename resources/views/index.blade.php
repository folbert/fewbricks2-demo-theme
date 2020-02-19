@extends('layouts.app')

@section('content')

  @include('partials.page-header')

  <div class="container">
    <div class="row">
      <div class="col-12">

    @if (!have_posts())
      <div class="alert alert-warning">
        {{ __('Sorry, no results were found.', 'fewbricks2-demo-theme') }}
      </div>
      {!! get_search_form(false) !!}
    @endif

    @while (have_posts()) @php the_post() @endphp
      @include('partials.content-'.get_post_type())
    @endwhile

      </div>
    </div>
  </div>

  {!! get_the_posts_navigation() !!}

@endsection

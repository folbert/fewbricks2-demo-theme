{{--
  Template Name: Two Columns
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.page-header')

    <div class="container">
      <div class="row">
        <div class="col-lg-7">

          {!!
              (new \App\Fewbricks\FieldGroups\SmartFieldGroup('', ''))
                  ->set_field_names_prefix('main_content_')
                  ->set_in_container('true')
                  ->render()
          !!}

        </div>

        <div class="col-lg-5">

          {!!
              (new \App\Fewbricks\FieldGroups\SmartFieldGroup('', ''))
                  ->set_field_names_prefix('secondary_content_')
                  ->set_in_container('true')
                  ->render()
          !!}

        </div>

      </div>

    </div>

  @endwhile
@endsection

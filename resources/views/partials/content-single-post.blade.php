<article @php post_class() @endphp>
  <header>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h1 class="entry-title">{!! get_the_title() !!}</h1>
          @include('partials/entry-meta', ['entry' => $post])
        </div>
      </div>
    </div>
  </header>
  <div class="entry-content">

    {!!
        (new \App\Fewbricks\FieldGroups\SmartFieldGroup())
            ->set_field_names_prefix('main_content_')
            ->render()
    !!}

  </div>
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-12">
          {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'fewbricks2-demo-theme'), 'after' => '</p></nav>']) !!}
        </div>
      </div>
    </div>
  </footer>

  <div class="container">
    <div class="row">
      <div class="col-12">
        @php comments_template('/partials/comments.blade.php') @endphp
      </div>
    </div>
  </div>

</article>

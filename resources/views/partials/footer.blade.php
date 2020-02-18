<footer class="content-info" style="padding: 48px 0; margin-top: 24px; background: #c0c0c0; border-top: solid 1px #000">

  <div class="container">
    <div class="row">
      <div class="col">
        FOOTER
      </div>
    </div>
    <div class="row">
      <div class="col">

        <b>{{ get_field('site_footer_col_1_headline', 'options') }}</b>

        {!!  (new \App\Fewbricks\Bricks\LinkGroup('', 'site_footer_col_1_links2')) // links_site_footer_col_1
            ->set_is_option(true)
            ->set_type(\App\Fewbricks\Bricks\LinkGroup::TYPE_NAV)
            ->render() !!}

      </div>
      <div class="col">

        <b>Col 2</b>

      </div>

      <div class="col">

        <b>Col 3</b>

      </div>

    </div>

  </div>

</footer>

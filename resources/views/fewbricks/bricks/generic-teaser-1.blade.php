<div class="{{ $main_wrapper_css_classes }}">

  @if($self->is_standalone())
    @component('fewbricks.layouts.wrapping-elements-1', $wrapping_elements_data)
  @endif

    @if(!$is_horizontal_layout)
      <div class="ec-m-generic-teaser-1__inner">
    @else
      <div class="{{ $image_col_css_classes }}">
    @endif

      @if(!empty($image_brick) && $image_brick->has_image())
      <div class="ec-m-generic-teaser-1__image">
        <div class="ec-m-generic-teaser-1__image-inner">
          {!! $image_brick->render() !!}
        </div>
      </div>
      @endif

    @if($is_horizontal_layout)
      </div> {{-- col --}}

          <div class="{{ $content_col_css_classes }}">
    @endif

      <div class="ec-m-generic-teaser-1__content">

        <div class="ec-m-generic-teaser-1__content-inner">

          @if(!empty($headline))
            <h3 class="ec-m-generic-teaser-1__headline">{{ $headline }}</h3>
          @endif

          @if(!empty($raw_text))
            <div class="ec-m-generic-teaser-1__text">{{ $text }}</div>
          @endif

          <a href="{!! $link_data['href'] !!}" class="btn btn-primary" target="{{ $link_data['target'] }}">{{ $button_text }}</a>

        </div>

      </div>

    </div {{-- /ec-m-generic-teaser-1__inner or column dependinhg on layout --}}>

  @if($self->is_standalone())
    @endcomponent
  @endif

</div>


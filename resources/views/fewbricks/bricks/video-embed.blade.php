<div class="{{ $main_wrapper_css_classes }}">

  @if($self->is_standalone())
    @component('fewbricks.layouts.wrapping-elements-1', $wrapping_elements_data)
  @endif

  <div class="embed-responsive embed-responsive-16by9">
    {!! $iframe_html !!}
  </div>

  @if($self->is_standalone())
    @endcomponent
  @endif

</div>

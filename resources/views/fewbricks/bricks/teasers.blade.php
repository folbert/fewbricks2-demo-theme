<div class="{{ $main_wrapper_css_classes }}">

  @if($self->is_standalone())
    @component('fewbricks.layouts.wrapping-elements-1', $wrapping_elements_data)
  @endif

    @foreach($teasers AS $teaser)

      <div class="{{ $column_css_classes }}">
        {!! $teaser->render() !!}
      </div>

    @endforeach

  @if($self->is_standalone())
    @endcomponent
  @endif

</div>

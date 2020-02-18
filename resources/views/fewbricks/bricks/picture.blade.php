{{-- The data-ec-parent attributes are siimply for debugging and isnt used by anything  --}}
<picture class="{{ $main_wrapper_css_classes }}" data-ec-parent-column-types="{{ $parent_column_types_string }}" data-ec-parent-container-types="{{ $parent_container_types_string }}"@ec_array_to_elm_attributes($extra_wrapper_attributes)>

  @if($self->is_standalone())
    @component('fewbricks.layouts.wrapping-elements-1', $wrapping_elements_data)
  @endif

  @foreach($sources AS $source)
  <source media="{{ $source['media'] }}"@ec_array_to_elm_attributes($source['extra_attributes'])>
  @endforeach

  <img src="{!! $img['src'] !!}" alt="{!! $img['alt'] !!}"@ec_array_to_elm_attributes($img['extra_attributes'])>

  @if($self->is_standalone())
    @endcomponent
  @endif

</picture>

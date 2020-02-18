{{-- The data-ec-parent attributes are siimply for debugging and isnt used by anything  --}}
<div class="{{ $main_wrapper_css_classes }}" data-ec-parent-column-types="{{ $parent_column_types_string }}" data-ec-parent-container-types="{{ $parent_container_types_string }}">

  @if($self->is_standalone())
    @component('fewbricks.layouts.wrapping-elements-1', $wrapping_elements_data)
  @endif

  @if($use_extra_wrapper)
    <div @ec_array_to_elm_attributes($extra_wrapper_attributes)>
  @endif

    <img src="{!! $img['src'] !!}" alt="{!! $img['alt'] !!}"@ec_array_to_elm_attributes($img['extra_attributes'])>

  @if($use_extra_wrapper)
    </div>
  @endif

  @if($self->is_standalone())
    @endcomponent
  @endif

</div>

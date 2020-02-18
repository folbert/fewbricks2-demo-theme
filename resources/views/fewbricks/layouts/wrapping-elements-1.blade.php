@php
  $use_container = isset($container_css_classes) && !empty($container_css_classes) && !$caller->get_force_skip_wrap_in_container();
  $use_row = isset($row_css_classes) && !empty($row_css_classes) && !$caller->get_force_skip_wrap_in_row();
  $use_column = isset($column_css_classes) && !empty($column_css_classes) && !$caller->get_force_skip_wrap_in_column();
@endphp

@if($use_container)
<div class="{{ $container_css_classes }}">
@endif

  @if($use_row)
  <div class="{{ $row_css_classes }}">
  @endif

    @if($use_column)
      <div class="{{ $column_css_classes }}">
    @endif

      {!! $slot !!}

    @if($use_column)
      </div>
    @endif

  @if($use_row)
  </div>
  @endif

@if($use_container)
</div>
@endif

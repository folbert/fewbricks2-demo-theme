<div class="ec-m ec-m-article">

  <?php /** @var \App\Fewbricks\Bricks\Brick $brick */ ?>
  @foreach($bricks AS $brick)

    {!! $brick->render() !!}

  @endforeach

</div>

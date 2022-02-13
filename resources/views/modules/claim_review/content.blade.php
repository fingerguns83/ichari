<?php
  $claimTypes = DB::table('claim_types')
    ->select('id', 'name', 'icon')
    ->where('review_requires_team', '<=', $userMaxPerm->team_id)
    ->get();
?>
@if ($claimTypes)
  @foreach ($claimTypes as $type)
    @include('/layouts/items/card', ['card' => 'review_card', 'id' => "type-" . $type->id])
  @endforeach
@endif
<script>
  function approve(id){
    console.log(id+": Approved");
  }
  function deny(id){
    console.log(id+": Denied");
  }

  function loadNew(id){
    var url = "/api/fetch_pending_claims?type="+id;
    $.get(url, function(data){
      if (data){
        console.log(data);
      }
    });
  }
  $(document).ready(function(){
    $("[id^=type-]").each(function(){
      var id = $(this).prop('id').replace('type-', '');
      loadNew(id);
    });
  });
  /*$("[id^=type-]").each(function(){
    var details = $(this).children('#details');
    var empty = $(this).children('#no-info');

    var location = details.children('#location').children('#data');
    var claimant = details.children('#claimant').children('#data');
    var coowners = details.children('#co-owners').children('#data');
    var analysis = details.children('#co-owners').children('#data');

  });*/
</script>
<?php
  if ($user->is_admin){
    $claimTypes = DB::table('claim_types')
    ->select('id', 'name', 'icon')
    ->get();
  }
  else {
    $claimTypes = DB::table('claim_types')
    ->select('id', 'name', 'icon')
    ->where('review_requires_team', '<=', $user->perm_level)
    ->get();
  }
?>
@if ($claimTypes)
  @foreach ($claimTypes as $type)
    @include('/layouts/components/card', ['format' => 'review_card', 'id' => "type-" . $type->id])
  @endforeach
@endif
<script>
  function loadNew(section){
    var url = "/api/claims/fetch_pending?type="+section;
    $.get(url, function(data){
      if (data){
        var details = $('#type-'+section).find('#details');
        var empty = $('#type-'+section).find('#no-info');
        var claimant = details.children('#claimant').children('#claimant-data');
        var locationnw = details.children('#coords-nw').children('#nw-data');
        var locationse = details.children('#coords-se').children('#se-data');
        var coowners = details.children('#coowners').children('#coowners-data');
        var analysis = details.children('#analysis').children('#analysis-data');
        var actions = details.children('#actions');
        var denyButton = details.children('#actions').children('#deny');
        var approveButton = details.children('#actions').children('#approve');
        var selfmod = details.children('#self-mod');

        var claim = JSON.parse(data);
        claimant.html(claim.requested_by.name);
        locationnw.html(claim.location.x1 + ', ' + claim.location.z1);
        locationse.html(claim.location.x2 + ', ' + claim.location.z2);
        if (claim.coowners){
            coowners.html('');
          claim.coowners.forEach(function(element){
            coowners.append('<img class="rounded-full mx-1" src="'+element['avatar']+'" width="24" height="24" title="'+element['name']+'">');
          });
        }
        else{
          coowners.html('n/a');
        }
        if (claim.analysis){
          analysis.css('color', '#dc2626');
          analysis.html(claim.analysis);
        }
        else {
          analysis.css('color', '#16a34a');
          analysis.html('OK');
        }

        if (claim.requested_by.id == {{Auth::id()}}){
          actions.hide();
          selfmod.show();
        }

        denyButton.click(function(){
          deny(claim.id, section);
        });
        approveButton.click(function(){
          approve(claim.id, section);
        });
        details.show();
        empty.hide();
      }
    });
  }
  function approve(claim_id, section){
    var url = "/api/claims/modify?status=4&id="+claim_id+"&reviewer={{Auth::id()}}";
    console.log(url);
    $.get(url, function(){
      loadNew(section);
    });
  }
  function deny(claim_id, section){
    var url = "/api/claims/modify?status=2&id="+claim_id+"&reviewer={{Auth::id()}}";
    console.log(url);
  }
  $(document).ready(function(){
    $("[id^=type-]").each(function(){
      var section = $(this).prop('id').replace('type-', '');
      loadNew(section);
    });
  });
  setInterval(function(){
    console.log("Reloading requests...");
    $("[id^=type-]").each(function(){
      var section = $(this).prop('id').replace('type-', '');
      loadNew(section);
    });
  }, 90000);
</script>
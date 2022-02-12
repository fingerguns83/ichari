<?php
  $claimTypes = DB::table('claim_types')
    ->select('id', 'name', 'icon')
    ->where('review_requires_team', '<=', $userMaxPerm->team_id)
    ->orderBy('review_requires_team', 'desc')
    ->get();
?>
@if ($claimTypes)
  @foreach ($claimTypes as $type)
    @include('/layouts/items/card', ['card' => 'review_card'])
  @endforeach
@endif
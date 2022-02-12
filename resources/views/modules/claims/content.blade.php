<?php
  use App\Models\Claim;
  
  $userClaims = DB::table('claim_has_users')
    ->select('claim_id')
    ->where('user_id', '=', Auth::id())
    ->get();
?>
@if ($userClaims)
  @foreach ($userClaims as $userClaim)
    @include('/layouts/items/card', ['card' => 'claim_card'])
  @endforeach
@endif

<?php
  use App\Models\Claim;
  
  $userClaims = DB::table('claim_has_users')
    ->select('claim_id')
    ->where('user_id', '=', Auth::id())
    ->get();
?>
<div class="flex content-center justify-center h-3/4 mt-12">
  <div class="w-full grid gap-2 grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 px-12 overflow-y-scroll scrollbar-thin scrollbar-thumb-sky-700 scrollbar-track-[#131314]">
    @if ($userClaims)
      @foreach ($userClaims as $userClaim)
        @include('/layouts/components/card', ['format' => 'claim_card'])
      @endforeach
    @endif
  </div>
</div>
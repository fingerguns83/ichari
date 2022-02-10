  <?php
    use App\Models\Claim;
  ?>
<div class="flex content-center justify-center h-5/6">
  <div class="w-full grid gap-2 grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 px-12 overflow-y-scroll scrollbar-hide">
      <?php
        $userClaims = DB::table('claim_has_users')
          ->select('claim_id')
          ->where('user_id', '=', Auth::id())
          ->get();
      ?>
    @if ($userClaims)
      @foreach ($userClaims as $userClaim)
        @include('/modules/cards/claim_card')
      @endforeach
    @endif
  </div>
</div>
<script>
  function dialogShow(){
    $('#dialog').show();
  }
  function dialogHide(){
    $('#dialog').hide();
    window.location.replace("https://ichari.isvserver.live/section/claims");
  }
</script>
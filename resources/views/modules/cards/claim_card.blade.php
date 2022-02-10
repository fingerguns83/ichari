<?php
  use App\Models\User;
  use App\Models\Claim;
  $claim = Claim::where('id', '=', $userClaim->claim_id)->first();
  $type = DB::table('claim_types')
    ->select('name', 'icon')
    ->where('id', '=', $claim->type)
    ->first();
  $status = DB::table('claim_statuses')
    ->select('name', 'color')
    ->where('id', '=', $claim->status)
    ->first();
  if ($claim->shared){
    $coowners = DB::table('claim_has_users')
      ->select('user_id')
      ->where('claim_id', '=', $claim->id)
      ->get();
  }
?>
<div class="flex justify-center">
  <div class="min-w-[240px] w-full max-w-[330px] h-[345px] py-6 bg-sky-300 rounded-2xl group">
    <div id="icon" class="flex w-full px-6 content-center items-center justify-center">
      <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="6em" height="6em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="<?=$type->icon; ?>" fill="currentColor"/></svg>  
    </div>
    <div id="type" class="flex flex-col w-full px-6 justify-center bg-sky-200 border-y-2 border-y-slate-200">
      <span class="block w-full font-medium text-2xl text-center"><?=$type->name; ?></span>
      <span class="block w-full font-medium text-center">
        <?php
          printf('(%s, %s to %s, %s)', $claim->northwest_x, $claim->northwest_z, $claim->southeast_x, $claim->southeast_z);
        ?>
      </span>
    </div>
    <div id="details" class="flex w-full mt-4 content-center items-center justify-center text-xl">
      <div>
        <div id="status" class="flex content-center items-center justify-center">
          <span>Status: <span class="font-bold" style="color: <?=$status->color; ?>"><?=ucwords($status->name); ?></span></span><br>
        </div>
        @if ($claim->shared)
          <div class="flex content-center items-center justify-center">
            <span class="justify-start">Co-Owner(s): </span>
          </div>
          <div class="flex content-center items-center justify-center mt-2">
            @foreach ($coowners as $coowner)
              @if ($coowner->user_id !== Auth::id())
                <?php $owner = User::where('id', '=', $coowner->user_id)->first(); ?>
                <img class="rounded-full mx-1" src="{{$owner->discord_avatar}}" width="32" height="32" title="{{$owner->discord_name}}">
              @endif
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

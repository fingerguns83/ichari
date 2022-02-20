<?php
  use App\Models\User;
  use App\Models\Claim;
  use App\Models\ClaimType;

  $claim = Claim::where('id', '=', $userClaim->claim_id)->first();
  $type = ClaimType::where('id', '=', $claim->type)->first();

  $status = DB::table('claim_statuses')
    ->where('id', '=', $claim->status)
    ->first();

  if ($claim->shared){
    $coowners = DB::table('claim_has_users')
      ->select('user_id')
      ->where('claim_id', '=', $claim->id)
      ->get();
  }
  if ($claim->reviewed_by){
    $reviewer = User::where('id', '=', $claim->reviewed_by)->first();
  }
  if ($claim->expires_on){
    $userTimezone = new DateTimeZone($user->timezone);
    $expireServer = new DateTime($claim->expires_on);
    $expireServer->setTimezone($userTimezone);
    $expires_on = $expireServer->format('F dS');
  }
  else {
    $expires_on = false;
  }

  $renewClaim = 'onclick=""';

?>
<div id="icon" class="flex w-full px-6 mt-6 content-center items-center justify-center">
  <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="6em" height="6em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="{{$type->icon}}" fill="currentColor" onclick="alert('Claim ID: {{$claim->id}}')"/></svg>  
</div>
<div id="type" class="flex flex-col w-full px-6 justify-center bg-sky-200 dark:bg-sky-700 border-y-2 border-y-slate-200">
  <span class="block w-full font-medium text-2xl text-center"><?=$type->name; ?></span>
  <span class="block w-full font-medium text-center">({{$claim->getLocationString()}})</span>
</div>
<div id="details" class="flex w-full mt-4 content-center items-center justify-center text-xl">
  <div>
    <div id="status" class="flex content-center items-center justify-center">
      <span>Status: 
        <span class="font-bold cursor-default" style="color: {{$status->color}}" {{$renewClaim}}>
          <?=ucwords($status->name); ?>
        </span>
      </span>
    </div>
    @if ($claim->reviewed_by)
      <?php $reviewer = User::where('id', '=', $claim->reviewed_by)->first(); ?>
      <div id="reviewer" class="flex content-center items-center justify-center text-sm">
        <span>Reviewed By: {{$reviewer->username}}</span>
      </div>
    @endif
    @if ($expires_on)
      <div id="expiring" class="flex content-center items-center justify-center">
        <span>Expires: <span class="text-base">{{$expires_on}}</span></span>
      </div>
    @endif
    @if ($claim->shared)
      <div class="flex content-center items-center justify-center mt-2">
        <span class="justify-start">Co-Owner(s): </span>
      <!--</div>-->
        <div class="flex content-center items-center justify-center ml-2">
          @foreach ($coowners as $coowner)
            @if ($coowner->user_id !== Auth::id())
              <?php $owner = User::where('id', '=', $coowner->user_id)->first(); ?>
              <img class="rounded-full mx-0.5" src="{{$owner->avatar}}" width="32" height="32" title="{{$owner->username}}">
            @endif
          @endforeach
        </div>
      </div>
    @endif
  </div>
</div>

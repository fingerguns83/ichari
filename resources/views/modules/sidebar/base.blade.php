<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

$user = Auth::user();
$user['id'];
?>

<div class="grid m-0 gap-0 col-span-1 h-screen bg-sky-600 content-between">
  <div>
    <!--Logo-->
    <div class="flex-row flex content-center justify-center items-center h-24 w-full min-w-[256px] py-16 border-b-sky-800 border-b-8">
      <img src="/images/ichari_blue.png" width="80" height="80" class="inline -ml-8"><span class="font-semibold text-5xl text-sky-100">iCHARI</span>
    </div>
    <!--Sidebar Items-->
    @include('/modules/sidebar/perm1')
  </div>
  <!--Account-->
  <div class="bottom-0 sticky flex flex-row content-center justify-left items-center h-24 w-full p-8 bg-sky-800 text-sky-100">
    <img src="{{$user['discord_avatar']}}" width="60" height="60" class="rounded-full">
    <p class="decoration-sky-100 hover:underline hover:cursor-pointer">
      <span class="font-medium text-xl ml-6"><?=$user['discord_name']; ?></span><br>
      <span class="font-normal text-md ml-6">View Account</span>
    </p>
  </div>
</div>

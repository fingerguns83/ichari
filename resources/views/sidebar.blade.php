<?php
use Illuminate\Support\Facades\DB;
if ($user->is_admin){
  $modules = DB::table('modules')
  ->select('name', 'icon')
  ->where('enabled', '=', 1)
  ->get();
}
else {
  $modules = DB::table('modules')
  ->select('name', 'icon')
  ->where('enabled', '=', 1)
  ->where('requires_perm', '<=', $user->perm_level)
  ->where('requires_perm', '>', 0)
  ->get();
}
?>

<div id="accountDialog" class="absolute grid grid-cols-6 w-full h-full z-10 top-0 left-0 bg-sky-900 dark:bg-[#1b1c1d] bg-opacity-20 dark:bg-opacity-20" style="display: none;">
  <div class="flex col-start-2 col-span-5 content-center items-center justify-center place-items-center">
    <div class="w-4/5 md:w-3/5 xl:w-5/12 2xl:w-2/5 h-auto px-8 py-4 pb-8 bg-slate-200 dark:bg-slate-700 rounded-3xl text-slate-700 dark:text-slate-200">
      <div class="flex w-full h-16 items-center justify-between pb-4 mb-8 text-3xl font-semibold border-b-2 border-gray-300">
        <span>Account</span><button id="hide-account-dialog" class="flex-none"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M12 2c5.53 0 10 4.47 10 10s-4.47 10-10 10S2 17.53 2 12S6.47 2 12 2m3.59 5L12 10.59L8.41 7L7 8.41L10.59 12L7 15.59L8.41 17L12 13.41L15.59 17L17 15.59L13.41 12L17 8.41L15.59 7z" fill="currentColor"/></svg>
        </span>
      </div>
      <div class="w-full text-2xl font-medium overflow-y-scroll scrollbar-hide">
        @include("/global_components/dialogs/account_dialog")
      </div>
    </div>
  </div>
</div>

<div class="flex flex-col gap-0 content-between w-1/6 min-w-[320px] h-screen bg-[#1b1c1d]">

    <!--Logo-->
    <div class="flex-row flex content-center justify-center items-center h-[96px] w-full min-w-[256px] py-16 border-b-[#1989ce] border-b-8">
      <img src="/images/hz_logo.png" width="250" height="125" class="inline">
    </div>
    <!--Sidebar Items-->
    <div class="w-full h-full min-h-[400px] overflow-y-scroll scrollbar-hide my-8 text-sky-100">
      <div>
        @foreach ($modules as $module)
          <div class="block group h-12 text-3xl">
            <a href="/module/{{$module->name}}" class="cursor-default">
              @if ($name == $module->name)
                <div class="text-[#1989ce] px-4 w-full">    
              @else
                <div class="group-hover:bg-[#323334] group-hover:cursor-pointer px-4 w-full">  
              @endif
                  <svg class="inline -mt-2" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1.125em" height="1.125em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="{{$module->icon}}" fill="currentColor"/></svg>
                  {{ucwords(str_replace('_', ' ', $module->name))}}
                </div>
            </a>
          </div>   
        @endforeach
      </div>
    </div>

  <!--Account-->
  <div class="sticky bottom-0 flex content-center justify-left items-center h-[96px] w-full p-8 bg-[#1b1c1d] border-t-2 border-t-[#1989ce] text-sky-100">
    <img src="{{$user['avatar']}}" width="60" height="60" class="rounded-full">
    <p class="decoration-sky-100">
      <span class="font-medium text-xl ml-6"><?=$user['username']; ?></span><br>
      <span id="show-account-dialog" class="font-normal text-md ml-6 hover:underline hover:cursor-pointer">Manage Account</span>
    </p>
  </div>
</div>
<script>
  $('#show-account-dialog').click(function(){
    $('#accountDialog').show();
  });
  $('#hide-account-dialog').click(function(){
    location.reload();
  });
</script>
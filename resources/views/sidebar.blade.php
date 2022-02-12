<?php
use Illuminate\Support\Facades\DB;

$modules = DB::table('modules')
  ->select('name', 'icon')
  ->where('requires_team', '<=', $userMaxPerm->team_id)
  ->get();
?>

<div class="flex flex-col gap-0 content-between w-1/6 min-w-[320px] h-screen bg-sky-600">

    <!--Logo-->
    <div class="flex-row flex content-center justify-center items-center h-[96px] w-full min-w-[256px] py-16 border-b-sky-800 border-b-8">
      <img src="/images/ichari_blue.png" width="80" height="80" class="inline -ml-8"><span class="font-semibold text-5xl text-sky-100">{{getenv('APP_NAME')}}</span>
    </div>
    <!--Sidebar Items-->
    <div class="w-full h-full min-h-[400px] overflow-y-scroll scrollbar-hide py-8 text-sky-100">
      <div>
        @foreach ($modules as $module)
          <div class="block group h-12 text-3xl">
            <a href="/module/{{$module->name}}" class="cursor-default">
              @if ($name == $module->name)
                <div class="bg-sky-700 px-4 w-full">    
              @else
                <div class="group-hover:bg-sky-800 px-4 w-full">  
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
  <div class="sticky bottom-0 flex content-center justify-left items-center h-[96px] w-full p-8 bg-sky-800 text-sky-100">
    <img src="{{$user['discord_avatar']}}" width="60" height="60" class="rounded-full">
    <p class="decoration-sky-100 hover:underline hover:cursor-pointer">
      <span class="font-medium text-xl ml-6"><?=$user['discord_name']; ?></span><br>
      <span class="font-normal text-md ml-6">View Account</span>
    </p>
  </div>
</div>

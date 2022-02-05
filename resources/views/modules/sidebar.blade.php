<?php
use Illuminate\Support\Facades\Auth;
$user = Auth::user();
$user['id'];
?>

<div class="grid m-0 gap-0 col-span-1 h-screen bg-sky-600 content-between">
  <div>
    <div class="flex-row flex content-center justify-center items-center h-24 w-full py-16 border-b-sky-800 border-b-8">
      <img src="/images/ichari_blue.png" width="80" height="80" class="inline -ml-8"><span class="font-semibold text-5xl text-sky-100">iCHARI</span>
    </div>
    <div class="w-full p-8 text-sky-100">
      <div class="flex-row h-16 content-center justify-left items-center text-3xl">
        <svg class="inline -mt-2.5" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="2.25rem" height="2.25rem" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3L2 12h3v8h5z" fill="currentColor"/></svg>
        Dashboard
      </div>
      <div class="flex-row h-16 text-3xl">
        <svg class="inline -mt-2.5" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="2.25rem" height="2.25rem" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M12 2c3.31 0 6 2.66 6 5.95C18 12.41 12 19 12 19S6 12.41 6 7.95C6 4.66 8.69 2 12 2m0 4a2 2 0 0 0-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2m8 13c0 2.21-3.58 4-8 4s-8-1.79-8-4c0-1.29 1.22-2.44 3.11-3.17l.64.91C6.67 17.19 6 17.81 6 18.5c0 1.38 2.69 2.5 6 2.5s6-1.12 6-2.5c0-.69-.67-1.31-1.75-1.76l.64-.91C18.78 16.56 20 17.71 20 19z" fill="currentColor"/></svg>
        Claims
      </div>
      <div class="flex-row h-16 text-3xl">
        <svg class="inline -mt-2.5" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="2.25rem" height="2.25rem" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M13.78 15.3l6 6l2.11-2.16l-6-6l-2.11 2.16m3.72-5.2c-.39 0-.81-.05-1.14-.19L4.97 21.25l-2.11-2.11l7.41-7.4L8.5 9.96l-.72.7l-1.45-1.41v2.86l-.7.7l-3.52-3.56l.7-.7h2.81l-1.4-1.41l3.56-3.56a2.976 2.976 0 0 1 4.22 0L9.89 5.74l1.41 1.4l-.71.71l1.79 1.78l1.82-1.88c-.14-.33-.2-.75-.2-1.12a3.49 3.49 0 0 1 3.5-3.52c.59 0 1.11.14 1.58.42L16.41 6.2l1.5 1.5l2.67-2.67c.28.47.42.97.42 1.6c0 1.92-1.55 3.47-3.5 3.47z" fill="currentColor"/></svg>
        Projects
      </div>
      <div class="flex-row h-16 text-3xl">
        <svg class="inline -mt-2.5" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="2.25rem" height="2.25rem" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2M9 17H7v-7h2v7m4 0h-2V7h2v10m4 0h-2v-4h2v4z" fill="currentColor"/></svg>
        Polls
      </div>
      <div class="flex-row h-16 text-3xl">
        <svg class="inline -mt-2.5" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="2.25rem" height="2.25rem" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M19 19H5V8h14m-3-7v2H8V1H6v2H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-1V1m-1 11h-5v5h5v-5z" fill="currentColor"/></svg>
        Calendar
      </div>
    </div>
  </div>
  <div class="bottom-0 sticky flex-row flex content-center justify-left items-center h-24 w-full p-8 bg-sky-800">
    <img src="{{$user['discord_avatar']}}" width="60" height="60" class="rounded-full">
    <p class="decoration-sky-100 hover:underline hover:cursor-pointer">
      <span class="font-medium text-xl ml-6 text-sky-100"><?=$user['discord_name']; ?></span><br>
      <span class="font-normal text-md text-sky-100 ml-6">View Account</span>
    </p>
  </div>
</div>

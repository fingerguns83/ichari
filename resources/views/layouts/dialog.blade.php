<?php

?>

<div id="{{$dialogId}}" class="absolute grid grid-cols-6 w-full h-full z-10 top-0 left-0" style="display: none;">
  <div class="flex col-start-2 col-span-5 content-center items-center justify-center place-items-center bg-sky-900 bg-opacity-20">
    <div class="w-4/5 md:w-3/5 xl:w-5/12 2xl:w-1/3 h-1/2 px-8 py-4 bg-slate-200 rounded-3xl text-slate-700">
      <div class="flex w-full h-16 items-center justify-between pb-4 mb-8 text-3xl font-semibold border-b-2 border-gray-300">
        <span><?= ucwords(str_replace('_', ' ', $dialog)); ?></span><button class="flex-none" onclick="hideDialog({{$dialogId}})"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M12 2c5.53 0 10 4.47 10 10s-4.47 10-10 10S2 17.53 2 12S6.47 2 12 2m3.59 5L12 10.59L8.41 7L7 8.41L10.59 12L7 15.59L8.41 17L12 13.41L15.59 17L17 15.59L13.41 12L17 8.41L15.59 7z" fill="currentColor"/></svg>
        </span>
      </div>
      <div class="w-full text-2xl font-medium">
        @includeIf("/modules/$name/dialogs/$dialog")
      </div>
    </div>
  </div>
</div>
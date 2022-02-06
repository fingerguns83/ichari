<?php

?>

<div id="new-request-dialog" class="absolute grid grid-cols-6 w-full h-full z-10 top-0 left-0">
  <div class="flex col-start-2 col-span-5 content-center items-center justify-center place-items-center bg-sky-900 bg-opacity-20">
    <div class="w-1/3 h-3/4 px-8 py-4 bg-slate-200 rounded-3xl text-slate-700">
      <div class="flex w-full h-16 items-center justify-center pb-4 mb-12 text-3xl font-semibold border-b-2 border-gray-300">
        <span><?= ucwords(str_replace('_', ' ', $dialog)); ?></span>
      </div>
      <div class="w-full text-2xl font-medium">
        @include('/modules/forms/'.$dialog)
      </div>
    </div>
  </div>
</div>
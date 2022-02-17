<?php

?>
<div id="heading" class="h-16 flex flex-col w-full px-6 justify-center bg-sky-200 dark:bg-sky-700 border-b-2 border-y-slate-200 rounded-t-2xl">
  <div class="flex justify-center text-3xl font-semibold">{{$type->name}}</div>
</div>
<div id="details" class="flex flex-col m-6 text-xl" style="display:none;">
  <div id="claimant" class="flex content-center items-center">
    <div id="claimant-label" class="font-semibold">Requested By: </div>
    <div id="claimant-data" class="ml-2">test</div>
  </div>
  <div id="coords-nw" class="flex content-center items-center">
    <div id="nw-label" class="font-semibold">Northwest Corner: </div>
    <div id="nw-data" class="ml-2">-7152, -1658</div>
  </div>
  <div id="coords-se" class="flex content-center items-center">
    <div id="se-label" class="font-semibold">Southeast Corner: </div>
    <div id="se-data" class="ml-2">-7487, -3190</div>
  </div>
  <div id="coowners" class="flex content-center items-center">
    <div id="coowners-label" class="font-semibold">Co-Owners: </div>
    <div id="coowners-data" class="flex ml-2"></div>
  </div>
  <div id="analysis" class="flex content-center items-center w-full truncate">
    <div id="analysis-label" class="font-semibold">Analysis: </div>
    <div id="analysis-data" class="ml-2">test</div>
  </div>
  <div id="self-mod" class="flex content-center items-center text-center mt-12 font-semibold" style="display:none;">
    You cannot review your own claim.
  </div>
  <div id="actions" class="flex justify-evenly mt-12">
    <button id="deny" class="w-[120px] px-2 py-1 flex content-center items-center justify-center text-2xl font-medium border-4 border-slate-700 rounded-xl hover:border-red-600 active:border-red-700 active:bg-red-300">Deny</button>
    <button id="approve" class="w-[120px] px-2 py-1 flex content-center items-center justify-center text-2xl font-medium border-4 border-slate-700 rounded-xl hover:border-green-600 active:border-green-700 active:bg-green-300">Approve</button>
  </div>
</div>
<div id="no-info" class="flex flex-col justify-center items-center content-center p-6 text-2xl font-bold text-sky-600 dark:text-slate-400">
  No claims in queue...
</div>


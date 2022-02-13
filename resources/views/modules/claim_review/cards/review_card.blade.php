<?php

?>
<div id="heading" class="h-16 flex flex-col w-full px-6 justify-center bg-sky-200 border-y-2 border-y-slate-200 rounded-t-2xl">
  <div class="flex justify-center text-3xl font-semibold">{{$type->name}}</div>
</div>
<div id="details" class="flex flex-col m-6 text-xl" style="">
  <div class="flex content-center items-center">
    <div id="claimant-label" class="font-semibold">Requested By: </div>
    <div id="claimant-data" class="ml-2">test</div>
  </div>
  <div class="flex content-center items-center">
    <div id="nw-label" class="font-semibold">Northwest Corner: </div>
    <div id="nw-data" class="ml-2">-7152, -1658</div>
  </div>
  <div class="flex content-center items-center">
    <div id="se-label" class="font-semibold">Southeast Corner: </div>
    <div id="se-data" class="ml-2">-7487, -3190</div>
  </div>
  <div class="flex content-center items-center">
    <div id="coowners-label" class="font-semibold">Co-Owners: </div>
    <div id="coowners-data" class="ml-2"></div>
  </div>
  <div class="flex content-center items-center w-full truncate">
    <div id="analysis-label" class="font-semibold">Analysis: </div>
    <div id="analysis-data" class="ml-2">test</div>
  </div>
  <div id="actions" class="flex justify-evenly mt-12">
    <button class="w-[120px] px-2 py-1 flex content-center items-center justify-center text-2xl font-medium border-4 border-slate-700 rounded-xl hover:border-red-600 active:border-red-700 active:bg-red-300" onclick="deny('{{$type->id}}')">Deny</button>
    <button class="w-[120px] px-2 py-1 flex content-center items-center justify-center text-2xl font-medium border-4 border-slate-700 rounded-xl hover:border-green-600 active:border-green-700 active:bg-green-300" onclick="approve('{{$type->id}}')">Approve</button>
  </div>
</div>
<div id="no-info" style="display:none;" class="flex flex-col justify-center items-center content-center p-6 text-2xl font-bold text-sky-600">
  No claims in queue...
</div>


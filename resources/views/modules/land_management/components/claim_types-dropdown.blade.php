<?php
  use App\Models\ClaimType;
  $types = ClaimType::where('id', '>', 0)->get();
?>
@foreach($types as $type)
<div class="flex w-full content-center justify-between items-center border-b-2 last:border-b-0 border-slate-600 px-6 py-4 first:pt-0">
  <div class="flex">
    <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="2em" height="2em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="{{$type->icon}}"/></svg>
    <span class="col-span-5 flex content-center items-center text-2xl">{{$type->name}}</span>
  </div>
  <div class="flex">
    <svg id="view-claim_type-{{$type->id}}" class="hover:cursor-pointer" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="2em" height="2em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M13 9h-2V7h2m0 10h-2v-6h2m-1-9A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2Z"/></svg>
    <svg id="edit-claim_type-{{$type->id}}" class="ml-2 hover:cursor-pointer" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="2em" height="2em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M20.71 7.04c.39-.39.39-1.04 0-1.41l-2.34-2.34c-.37-.39-1.02-.39-1.41 0l-1.84 1.83l3.75 3.75M3 17.25V21h3.75L17.81 9.93l-3.75-3.75L3 17.25Z"/></svg>
  </div>
</div>
@endforeach
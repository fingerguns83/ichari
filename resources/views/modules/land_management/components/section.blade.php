<div class="w-full content-center items-center my-4 bg-sky-200 dark:bg-sky-700 rounded-2xl">
  <div id="{{$sectionName}}-header" class="flex w-full justify-between content-center items-center px-4">
    <div class="flex content-center items-center">
      @if($sectionName == "claims")
        <span class="text-3xl py-4">Administrative Claims</span>
      @else
        <span class="text-3xl py-4">{{ucwords(str_replace('_', ' ', $sectionName))}}</span>
      @endif
      <svg id="add-{{$sectionName}}" class="ml-2 hover:cursor-pointer" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="2em" height="2em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M17 13h-4v4h-2v-4H7v-2h4V7h2v4h4m-5-9A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2z" fill="currentColor"/></svg>
    </div>
    <svg id="{{$sectionName}}-expand" class="hover:cursor-pointer" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="3em" height="3em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
      <g transform="rotate(0 12 12)"><path fill="currentColor" d="M7.41 8.58L12 13.17l4.59-4.59L18 10l-6 6l-6-6l1.41-1.42Z"/></g>
    </svg>
  </div>
  <div id="{{$sectionName}}-details" class="flex-col bg-sky-300 dark:bg-slate-700 pt-6 rounded-b-2xl" style="display:none;">
    <div class="w-full max-h-[240px] overflow-y-scroll scrollbar-hide">
      @includeIf("/modules/land_management/components/$sectionName-dropdown")
    </div>
  </div>
</div>
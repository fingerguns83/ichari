<div class="flex content-center items-center justify-between w-full h-1/6 px-24">
  <span id="title" class="text-5xl font-semibold">{{ucwords(str_replace('_', ' ', $show))}}</span>
  @includeIf("/modules/header/$show")
</div>
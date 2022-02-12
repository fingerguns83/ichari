<div class="flex content-center items-center justify-between w-full h-1/6 px-12">
  <span id="title" class="text-5xl font-semibold">{{ucwords(str_replace('_', ' ', $name))}}</span>
  @includeIf("/modules/$name/header")
</div>
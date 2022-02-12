<div class="flex content-center items-center justify-between w-full h-1/6 px-12">
  <div class="flex items-center content-center">
    <span id="title" class="text-5xl font-semibold">{{ucwords(str_replace('_', ' ', $name))}}</span>
    <span class="hover:cursor-pointer" onclick="showDialog('#infoDialog')"><svg class="ml-2" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="2em" height="2em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M13 9h-2V7h2m0 10h-2v-6h2m-1-9A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2z" fill="currentColor"/></svg></span>
  </div>
  @includeIf("/modules/$name/header")
</div>
<script>
  function showDialog(id){
    $(id).show();
  }
  function hideDialog(id){
    $(id).hide();
    location.reload();
  }
</script>
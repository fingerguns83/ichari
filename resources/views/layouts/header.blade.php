<div class="flex content-center items-center justify-between w-full h-[136px] mb-12 border-b-8 border-slate-400 dark:border-slate-600 px-12">
  <div class="flex items-center content-center">
    <span id="title" class="text-5xl font-semibold">{{ucwords(str_replace('_', ' ', $name))}}</span>
    <span class="hover:cursor-pointer" onclick="showDialog('#infoDialog')"><svg class="ml-2" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="2em" height="2em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M15.07 11.25l-.9.92C13.45 12.89 13 13.5 13 15h-2v-.5c0-1.11.45-2.11 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41a2 2 0 0 0-2-2a2 2 0 0 0-2 2H8a4 4 0 0 1 4-4a4 4 0 0 1 4 4a3.2 3.2 0 0 1-.93 2.25M13 19h-2v-2h2M12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10c0-5.53-4.5-10-10-10z" fill="currentColor"/></svg></span>
  </div>
  @includeIf("/modules/$name/header_actions")
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
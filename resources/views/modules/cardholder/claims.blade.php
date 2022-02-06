  <div class="flex content-center items-center gap-4 mb-12 justify-between w-full h-12">
    <span id="title" class="text-5xl font-semibold">{{Str::ucfirst($show)}}</span>
    <button class="flex px-2 py-1 text-2xl content-center items-center font-medium border-2 border-slate-600 rounded-xl hover:border-sky-500 hover:bg-sky-100 hover:bg-opacity-50" onclick="newRequest()">
      <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M17 13h-4v4h-2v-4H7v-2h4V7h2v4h4m-5-9A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2z" fill="currentColor"/></svg>
      <span class="ml-2">New Request</span>
    </button>
  </div>
@include('/modules/dialogs/base', ['dialog' => 'new_claim_request'])
<div class="grid grid-rows-2 gap-8 grid-cols-4 h-5/6">
  @for ($i = 0; $i < 4; $i++)
    <?php
      $type = $i;
      if ($i == 3){
        $type = 2;
      }
    ?>
    <div class="w-full h-full py-6 bg-sky-300 hover:bg-cyan-400 hover:cursor-pointer rounded-2xl group">
      <div id="icon" class="flex w-full px-6 content-center items-center justify-center">
        @switch($type)
          @case(0)
            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="6em" height="6em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M17 16h-2v6h-3v-5H8v5H5v-6H3l7-6l7 6M6 2l4 4H9v3H7V6H5v3H3V6H2l4-4m12 1l5 5h-1v4h-3V9h-2v3h-1.66L14 10.87V8h-1l5-5z" fill="currentColor"/></svg>
            @break
          @case(1)
            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="6em" height="6em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M2 13h2v2h2v-2h2v2h2v-2h2v2h2v-5l3-3V1h2l4 2l-4 2v2l3 3v12H11v-3a2 2 0 0 0-2-2a2 2 0 0 0-2 2v3H2v-9m16-3c-.55 0-1 .54-1 1.2V13h2v-1.8c0-.66-.45-1.2-1-1.2z" fill="currentColor"/></svg>        
            @break
          @case(2)
            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="6em" height="6em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M12 18H6v-4h6m9 0v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6m0-10H4v2h16V4z" fill="currentColor"/></svg>
            @break
        @endswitch
      </div>
      <div id="type" class="flex flex-col w-full px-6 justify-center bg-sky-200 border-y-2 border-y-slate-200">
        @switch($type)
          @case(0)
            <span class="block w-full font-medium text-2xl text-center">Spawn Home</span>
            <span class="block w-full font-medium text-center">(-300, -250 to -330, -280)</span>
            @break
          @case(1)
            <span class="block w-full font-medium text-2xl text-center">Main Base</span>
            <span class="block w-full font-medium text-center">(-8000, 300 to -8240, 60)</span>
            @break
          @case (2)
            <span class="block w-full font-medium text-2xl text-center">Shop</span>
            <span class="block w-full font-medium text-center">(750, 890 to 720, 920)</span>
            @break
        @endswitch
      </div>
      <div id="details" class="flex w-full p-6 content-center items-center justify-center text-xl">
        <?php $status = rand(0,2); ?>
        @switch($status)
          @case(0)
            <span>Status: <span class="text-red-600 font-bold">Denied</span></span>
            @break
          @case(1)
            <span>Status: <span class="text-orange-500 font-bold">Pending</span></span>   
            @break
          @case(2)
            <span>Status: <span class="text-green-600 font-bold">Approved</span></span>
            @break
        @endswitch
      </div>
    </div>
  @endfor
</div>

<script>
  function newRequest(){
    $('#new-request-dialog').show();
  }
  function closeRequest(){
    $('#new-request-dialog').hide();
  }
</script>
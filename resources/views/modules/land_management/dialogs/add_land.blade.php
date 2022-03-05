<?php
use App\Http\Controllers\LandManagementController;
?>
<div id="addForm" class="text-3xl">
  <div id="dimension" style="display: none;">
    {!! Form::open(['action' => [[LandManagementController::class, 'add'], 'dimension'], 'id' => 'add_dimension_form']) !!}
    <div class="flex justify-left items-center content-center">
      {!! Form::label('dimension-name', 'Name:') !!}
      {!! Form::text('dimension-name', '', ['class' => 'w-3/5 px-2 ml-2 dark:bg-slate-600']) !!}
    </div>
    <div class="flex justify-left items-center content-center mt-8">
      <span>Size:</span>
      <div class="w-3/5 lg:w-1/2 content-center items-center ml-8 text-2xl">
        <div id="adddim-coords1" class="flex content-center items-center justify-left">
          <span class="mr-2">{{ Form::label('adddim-x1', 'X: ') }}</span>
          {{ Form::number('adddim-x1', '0', ['class' => 'w-3/5 px-2 dark:bg-slate-600']) }}
          <span class="m-2">{{ Form::label('adddim-z1', 'Z: ') }}</span>
          {{ Form::number('adddim-z1', '0', ['class' => 'w-3/5 px-2 dark:bg-slate-600']) }}
        </div>
        <div id="adddim-coords2" class="flex content-center items-center justify-left">
          <span class="mr-2">{{ Form::label('adddim-x2', 'X: ') }}</span>
          {{ Form::number('adddim-x2', '0', ['class' => 'w-3/5 px-2 dark:bg-slate-600']) }}
          <span class="m-2">{{ Form::label('adddim-z2', 'Z: ') }}</span>
          {{ Form::number('adddim-z2', '0', ['class' => 'w-3/5 px-2 dark:bg-slate-600']) }}
        </div>    
      </div>
    </div>
    <div class="flex mt-8">
    {{ Form::button('Submit', ['class' => 'px-4 py-2 text-3xl text-slate-700 dark:text-slate-200 border-2 border-slate-600 dark:border-slate-200 hover:border-sky-500 active:border-sky-400 hover:bg-sky-200 dark:hover:bg-sky-800 hover:bg-opacity-50 rounded-xl', 'id' => 'adddim-submit']) }}
    </div>
    <div id="adddim-hidden">
    </div>
  </div>
  <script>
    $('#adddim-submit').click(function(){
      var input = {};
      var coords = {};

      input.x1 = $('#adddim-x1').val();
      input.z1 = $('#adddim-z1').val();
      input.x2 = $('#adddim-x2').val();
      input.z2 = $('#adddim-z2').val();
      
      if (input.x1 < input.x2){
        coords.x1 = input.x1;
        coords.x2 = input.x2;
      }
      else {
        coords.x1 = input.x2;
        coords.x2 = input.x1;
      }
      if (input.z1 < input.z2){
        coords.z1 = input.z1;
        coords.z2 = input.z2;
      }
      else {
        coords.z1 = input.z2;
        coords.z2 = input.z1;
      }
      for (const [key, value] of Object.entries(coords)){
        $('#adddim-hidden').append('<input type="text" name="coords['+key+']" value="'+value+'" style="display:none;">');
      }
      $('#add_dimension_form').submit();
    });
  </script>

  <div id="area" style="display: none;">
    Add Area
  </div>
  <div id="claim_type" style="display: none;">
    Add Claim Type
  </div>
  <div id="claim" style="display: none;">
    Add Administrative Claim
  </div>
</div>


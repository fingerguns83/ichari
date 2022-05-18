<?php
  use App\Models\Dimension;
  use App\Models\ClaimType;
  use App\Models\Claim;
  use App\Models\Area;
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
    {!! Form::close() !!}
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
    {!! Form::open(['action' => [[LandManagementController::class, 'add'], 'claim_type'], 'id' => 'add_claim_type_form']) !!}
    <div class="flex justify-left items-center content-center">
      {!! Form::label('claim_type-name', 'Name:') !!}
      {!! Form::text('claim_type-name', '', ['class' => 'w-3/5 px-2 ml-2 dark:bg-slate-600']) !!}
    </div>
    <?php
      $icons = DB::table('icons')
        ->select('name', 'path')
        ->get();
    ?>
    <div class="flex mt-6 content-center items-center">
      Icon:
      <select id="claim_type-icon" name="claim_type-icon" class="dark:bg-slate-600 ml-2 px-4" required>
          <option id="claim_type-icon-default" disabled selected>--Select Icon--</option>
        @foreach($icons as $icon)
          <option value="{{$icon->path}}">{{ucwords(str_replace('-', ' ', $icon->name))}}</option>
        @endforeach
      </select>
      <svg class="ml-2" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="2em" height="2em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
        <path id="addclaimtype-icon-preview" fill="currentColor" d=""/>
      </svg>
    </div>
    <div class="flex mt-6 content-center items-center">
      <?php
        $dimensions = Dimension::all();
      ?>
      Dimension:
      <select id="claim_type-dimension" name="claim_type-dimension" class="dark:bg-slate-600 ml-2 px-4" required>
        <option value="0" disabled selected>--Select Dimension--</option>
        @foreach($dimensions as $dimension)
          <option value="{{$dimension->id}}">{{ucwords(str_replace('_', ' ', $dimension->name))}}</option>
        @endforeach
      </select>
    </div>
    <div class="mt-6 content-center items-center">
      <?php
        $areas = Area::all();
      ?>
      <span>Bind to Area:</span>
      <select id="claim_type-area" name="claim_type-area" class="dark:bg-slate-600 ml-2 px-4" required>
        <option value="0" selected>None</option>
        @foreach($areas as $area)
          <option value="{{$area->id}}">{{ucwords(str_replace('_', ' ', $area->name))}}</option>
        @endforeach
      </select>
    </div>
    <div class="flex mt-6 content-center items-center">
      {!! Form::label('preapp', 'Pre-Apportioned:', ['class' => 'mr-2']) !!}
      {!! Form::checkbox('preapp', 'true', '', ['id' => 'preapp', 'class' => 'form-checkbox dark:bg-slate-600 text-sky-500 h-6 w-6']) !!}
    </div>
    <div id="plot_upload" class="mt-6 content-center items-center" style="display:none;">
      Upload .csv file of plot IDs:
      {!! Form::file('plots', ['accept' => '.csv', 'class' => 'form-file dark:bg-slate-600 text-xl']) !!}
    </div>
    <div id="claim_type-sizing">
      <div class="flex mt-6 content-center items-center">
        Measured By:
        {!! Form::radio('measured_by', 'chunks', true, ['class' => 'ml-2 form-radio dark:bg-slate-600 text-sky-500 h-6 w-6']) !!}
        <span class="ml-2 mr-4">chunks</span>
        {!! Form::radio('measured_by', 'blocks', '', ['class' => 'form-radio dark:bg-slate-600 text-sky-500 h-6 w-6']) !!}
        <span class="ml-2">blocks</span>
      </div>
      <div class="flex mt-6 content-center items-center">
        Size:
        {!! Form::number('size', 0, ['class' => 'w-1/6 px-2 ml-2 dark:bg-slate-600']) !!}
      </div>
      <div class="flex mt-6 content-center items-center">
        {!! Form::label('shareable', 'Shareable:', ['class' => 'mr-2']) !!}
        {!! Form::checkbox('shareable', 'true', '', ['id' => 'shareable', 'class' => 'form-checkbox dark:bg-slate-600 text-sky-500 h-6 w-6']) !!}
      </div>
      <div id = "shared-size-toggle" style="display:none;">
        <div class="flex mt-6 content-center items-center">
          Shared Size:
          {!! Form::number('shared_size', 0, ['class' => 'w-1/6 px-2 ml-2 dark:bg-slate-600']) !!}
        </div>
      </div>
      <div class="flex mt-6 content-center items-center">
        Buffer (blocks):
        {!! Form::number('buffer_size', 0, ['class' => 'w-1/6 px-2 ml-2 dark:bg-slate-600']) !!}
      </div>
      <div class="mt-6 content-center items-center">
        <div>Amount Allowed Per Player:</div>
        {!! Form::number('amount_allowed', 0, ['class' => 'w-1/6 px-2 dark:bg-slate-600']) !!}
      </div>
      <div class="mt-6 content-center items-center">
        <?php
          $permissions = DB::table('permissions')
                          ->where('id', '>', 1)
                          ->orderBy('id', 'desc')
                          ->get();
        ?>
        <div>Permission Level Required for Review:</div>
        <select id="claim_type-perm" name="claim_type-area" class="dark:bg-slate-600 px-4" required>
          <option value="0" disabled selected>--Select Permission Level--</option>
          @foreach($permissions as $permission)
            <option value="{{$permission->id}}">{{ucwords(str_replace('_', ' ', $permission->name))}}</option>
          @endforeach
        </select>

      </div>
    </div>
  </div>
  <script>
    $('#claim_type-icon').change(function(){

      $('#addclaimtype-icon-preview').attr('d', $('#claim_type-icon').val());
    });
    $('#preapp').change(function(){
      $('#claim_type-sizing').toggle();
      $('#plot_upload').toggle();
    });
    $('#shareable').change(function(){
      $('#shared-size-toggle').toggle();
      if ($('#shared-size-toggle').is(":visible")){
        $("input[name=shared_size]").val($("input[name=size]").val());
        $("input[name=shared_size]").focus();
      }
    });
  </script>
  <div id="administrative_claim" style="display: none;">
    {!! Form::open(['action' => [[LandManagementController::class, 'add'], 'admin_claim'], 'id' => 'add_admin_claim_form']) !!}
    <div class="flex justify-left items-center content-center">
      {!! Form::label('admin_claim-name', 'Name:') !!}
      {!! Form::text('admin_claim-name', '', ['class' => 'w-3/5 px-2 ml-2 dark:bg-slate-600']) !!}
    </div>
    <div class="flex justify-left items-center content-center mt-8">
      <span>Size:</span>
      <div class="w-3/5 lg:w-1/2 content-center items-center ml-8 text-2xl">
        <div id="add_admin_claim-coords1" class="flex content-center items-center justify-left">
          <span class="mr-2">{{ Form::label('add_admin_claim-x1', 'X: ') }}</span>
          {{ Form::number('add_admin_claim-x1', '0', ['class' => 'w-3/5 px-2 dark:bg-slate-600']) }}
          <span class="m-2">{{ Form::label('add_admin_claim-z1', 'Z: ') }}</span>
          {{ Form::number('add_admin_claim-z1', '0', ['class' => 'w-3/5 px-2 dark:bg-slate-600']) }}
        </div>
        <div id="add_admin_claim-coords2" class="flex content-center items-center justify-left">
          <span class="mr-2">{{ Form::label('add_admin_claim-x2', 'X: ') }}</span>
          {{ Form::number('add_admin_claim-x2', '0', ['class' => 'w-3/5 px-2 dark:bg-slate-600']) }}
          <span class="m-2">{{ Form::label('add_admin_claim-z2', 'Z: ') }}</span>
          {{ Form::number('add_admin_claim-z2', '0', ['class' => 'w-3/5 px-2 dark:bg-slate-600']) }}
        </div>    
      </div>
    </div>
    <div class="flex mt-8">
    {{ Form::button('Submit', ['class' => 'px-4 py-2 text-3xl text-slate-700 dark:text-slate-200 border-2 border-slate-600 dark:border-slate-200 hover:border-sky-500 active:border-sky-400 hover:bg-sky-200 dark:hover:bg-sky-800 hover:bg-opacity-50 rounded-xl', 'id' => 'add_admin_claim-submit']) }}
    </div>
    <div id="add_admin_claim-hidden">
    </div>
    {!! Form::close() !!}
  </div>
  <script>
    $('#add_admin_claim-submit').click(function(){
      var input = {};
      var coords = {};

      input.x1 = $('#add_admin_claim-x1').val();
      input.z1 = $('#add_admin_claim-z1').val();
      input.x2 = $('#add_admin_claim-x2').val();
      input.z2 = $('#add_admin_claim-z2').val();
      
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
        $('#add_admin_claim-hidden').append('<input type="text" name="coords['+key+']" value="'+value+'" style="display:none;">');
      }
      $('#add_admin_claim_form').submit();
    });
  </script>
</div>


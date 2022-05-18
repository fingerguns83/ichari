<?php
use Illuminate\Support\Facades\DB;
use Collective\Html\FormFacade;
use Symfony\Component\Routing\Route;
?>

  {{ Form::open(['url' => '/forms/claim-request', 'name' => 'new_claim_request', 'id' => 'new_claim_request_form']) }}

<!--type-->
<div class="flex content-evenly items-center justify-left" id="claim-type">
  <div>
    <span class="mr-2">{{ Form::label('type', 'Claim Type:') }}</span>
    <?php
      $claimTypesDB = DB::table('claim_types')
        ->where('id', '>', 0)
        ->get();
      foreach ($claimTypesDB as $type){
        $claimTypes[$type->id] = $type->name;
      }
    ?>
    {{ Form::select('type', $claimTypes, '', ['class' => 'dark:bg-slate-600']) }}
  </div>
  {{ Form::button('<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1.5em" height="1.5em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M22 12a10 10 0 0 1-10 10A10 10 0 0 1 2 12A10 10 0 0 1 12 2a10 10 0 0 1 10 10m-12 6l6-6l-6-6l-1.4 1.4l4.6 4.6l-4.6 4.6L10 18z" fill="currentColor"/></svg>', ['class' => 'text-slate-700 hover:text-sky-500 dark:text-slate-200 dark:hover:text-sky-500 ml-2', 'id' => 'submit-type']) }}
</div>


<!--location-->
<div>
  <div id="location" class="content-center items-center justify-left w-full" style="display: none;">
    <span id="location-label" class="block mr-2">{{ Form:: label('Enter coordinates of opposite corners of requested area:', '')}}</span>
    <div class="flex justify-left items-center content-center">
      <div id="location-coords" class="w-1/2 items-baseline">
        <div class="flex content-center items-center justify-left">
          <span class="mr-2">{{ Form::label('x1', 'X: ') }}</span>
          {{ Form::number('x1', '0', ['class' => 'w-3/5 dark:bg-slate-600']) }}
          <span class="m-2">{{ Form::label('z1', 'Z: ') }}</span>
          {{ Form::number('z1', '0', ['class' => 'w-3/5 dark:bg-slate-600']) }}
        </div>
        <div class="flex content-center items-center justify-left">
          <span class="mr-2">{{ Form::label('x2', 'X: ') }}</span>
          {{ Form::number('x2', '0', ['class' => 'w-3/5 dark:bg-slate-600']) }}
          <span class="m-2">{{ Form::label('z2', 'Z: ') }}</span>
          {{ Form::number('z2', '0', ['class' => 'w-3/5 dark:bg-slate-600']) }}
        </div>    
      </div>
      <span id="shared-claim" class="ml-4" style="display:none;">
        <span class="mr-2 text-xl">{{ Form::label('shared', 'Shared claim ')}}</span>
        {{ Form::checkbox('shared', 'shared', false, ['class' => 'form-checkbox dark:bg-slate-600 text-sky-500 h-6 w-6']) }}
      </span>
      {{ Form::button('<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1.5em" height="1.5em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M22 12a10 10 0 0 1-10 10A10 10 0 0 1 2 12A10 10 0 0 1 12 2a10 10 0 0 1 10 10m-12 6l6-6l-6-6l-1.4 1.4l4.6 4.6l-4.6 4.6L10 18z" fill="currentColor"/></svg>', ['class' => 'text-slate-700 hover:text-sky-500 dark:text-slate-200 dark:hover:text-sky-500 ml-2', 'id' => 'submit-location']) }}
    </div>
    <div class="flex content-center justify-start items-center mt-2">
      {{ Form::button('Check Size', ['class' => 'px-4 border-2 border-slate-600 dark:border-slate-200 hover:border-sky-500 active:border-sky-400 hover:bg-sky-100 dark:hover:bg-sky-800 hover:bg-opacity-50 rounded-xl', 'id' => 'check-size']) }}
      <span id="size-output" class="ml-4 text-xl"></span>
      <span id="size-output-error" class="text-xl ml-4 text-red-500"></span>
    </div>
  </div>
</div>

<!--Preapportionment-->
<div id="apportionment" style="display:none;">
  teset
</div>

<!--Co-Owners-->
<div id="co-owners" style="display:none;">
  <div id="owners-selection" class="flex content-center items-center justify-left">
    <span id="owners-label" class="block mr-2">{{ Form:: label('Co-owner(s): ', '')}}</span>
    <?php
      $allUsers = DB::table('users')
        ->select('id', 'username')
        ->where('id', '!=', Auth::id())
        ->get();
      $availableUsers = [];
      foreach ($allUsers as $user){
        $availableUsers[$user->username] = $user->username;
      }
    ?>
    {{ Form::select('owners', $availableUsers, '', ['id' => 'owners', 'class' => 'dark:bg-slate-600', 'disabled'])}}
    {{ Form::button('<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1.5em" height="1.5em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M22 12a10 10 0 0 1-10 10A10 10 0 0 1 2 12A10 10 0 0 1 12 2a10 10 0 0 1 10 10m-12 6l6-6l-6-6l-1.4 1.4l4.6 4.6l-4.6 4.6L10 18z" fill="currentColor"/></svg>', ['class' => 'text-slate-700 hover:text-sky-500 dark:text-slate-200 dark:hover:text-sky-500 ml-2', 'id' => 'submit-owners']) }}
    
  </div>
  <ul id="owners-added" class="mt-2">
    
  </ul>
</div>

<!--review & submit request-->
<div id="review" style="display: none;">
  <div class="mb-4 text-3xl underline">Review:</div>
  <div id="review-details">
    <span id="review-type" class="font-medium">Claim Type:
      <span id="review-type-content" class="ml-2 font-normal">test</span>
    </span><br>
    <span id="review-location" class="font-medium">Location:
      <span id="review-location-content" class="ml-2 font-normal">test</span>
    </span><br>
    <div id="review-owners" class="grid grid-cols-5 w-full">
      <div class="font-medium">Owners:</div>
      <div class="ml-2 font-normal col-span-4">
        <ul id="review-owners-content">
        </ul>
      </div>
    </div>
  </div>
  <div id="submit-container" class="flex content-center justify-center items-center mt-6">
  {{ Form::button('Submit Request', ['class' => 'px-4 py-2 text-3xl text-slate-700 dark:text-slate-200 border-2 border-slate-600 dark:border-slate-200 hover:border-sky-500 active:border-sky-400 hover:bg-sky-200 dark:hover:bg-sky-800 hover:bg-opacity-50 rounded-xl', 'id' => 'submit-request']) }}
  </div>
</div>
{{ Form::close() }}

<!--javascript-->
<script>

  var typeId = 0;
  var coords = {};
  var claimType = {};
  $('#submit-type').click(function(){
    $('#submit-type').hide();
      $('#type').prop('disabled', true);
      $('#type').css('color', 'gray');
      typeId = $('#type').val();

      $.get('https://ichari.isvserver.live/api/fetch_model?table=claim_types&id='+typeId, function(data){
        claimType = jQuery.parseJSON(data);
        console.log(claimType);
        if (claimType.shareable){
          $('#shared-claim').show();
        }
        if (claimType.preapportioned){
          $('#claim-type').hide("slide", { direction: "left" }, 400, function(){
            $('#apportionment').fadeIn(400);
          });
        } 
        else { 
          $('#claim-type').hide("slide", { direction: "left" }, 400, function(){
            $('#location').fadeIn(400);
          });
        }
      });   
  });

  var locationValid = false;

  var shared = false;
  var claimCoords = [];
  function displaySize(outputSize = true){
    shared = $('#shared').prop('checked');

    if (!shared){
      var chunkAdd = Math.round((claimType.size/2));
      var chunkSubtract = -Math.round(-(claimType.size/2));
    }
    else {
      var chunkAdd = Math.round((claimType.shared_size/2));
      var chunkSubtract = -Math.round(-(claimType.shared_size/2));
    }

      input_x1 = $('#x1').val();
      input_z1 = $('#z1').val();
      input_x2 = $('#x2').val();
      input_z2 = $('#z2').val();

      if (input_x1 < input_x2){
        coords['x1'] = input_x1;
        coords['x2'] = input_x2;
      }
      else {
        coords['x1'] = input_x2;
        coords['x2'] = input_x1;
      }
      if (input_z1 < input_z2){
        coords['z1'] = input_z1;
        coords['z2'] = input_z2;
      }
      else {
        coords['z1'] = input_z2;
        coords['z2'] = input_z1;
      }

      var size_x = Math.abs(coords['x2'] - coords['x1']) + 1;
      var size_z = Math.abs(coords['z2'] - coords['z1']) + 1;
      var output = size_x+' × '+size_z;

      if (!shared){
        if (size_x != claimType.size || size_z != claimType.size){
          $('#size-output-error').html('Incorrect Size');
          locationValid = false;
        }
        else {
          $('#size-output-error').html('');
          locationValid = true;
          claimCoords = coords;
        }
      }
      else {
        if (size_x != claimType.shared_size || size_z != claimType.shared_size){
          $('#size-output-error').html('Incorrect Size');
          locationValid = false;
        }
        else {
          $('#size-output-error').html('');
          locationValid = true;
          claimCoords = coords;
        }
      }

      $('#size-output').html(output);
    
  }

  $('#check-size').click(function(){
    displaySize();
  });

  $('#submit-location').click(function(){
    displaySize(false)
    if (locationValid){
      $('#x1, #x2, #z1, #z2, #check-size, #shared').prop('disabled', true);
      

      if (shared){
        $('#owners').prop('disabled', false);
        $('#owners').prepend('<option id="owners-default" disabled selected value>--Select A Player--</option>');
        $('#location').hide("slide", { direction: "left" }, 400, function(){
          $('#co-owners').fadeIn(400);
        });
        
      }
      else {
        $('#location').hide("slide", { direction: "left" }, 400, function(){
            $('#review-type-content').html(claimType.name);
            $('#review-location-content').html(claimCoords['x1']+', '+claimCoords['z1']+' to '+claimCoords['x2']+', '+claimCoords['z2']);
            $('#review-owners').hide();
          $('#review').fadeIn(400);
        });
      }
    }

  });


  var coowners = [];
  $('#owners').change(function(){
    var newOwner = $('#owners').val();
    if (newOwner){
      if (coowners.length < 4){
        coowners.push(newOwner);
        $("#owners > option[value="+newOwner+"]").prop('disabled', true);
        $('#owners-default').prop('selected', true);
        $('#owners-added').append('<span id="'+newOwner+'"class="flex items-center content-center"><svg onclick="removeOwner('+"'"+newOwner+"'"+')" class="mr-2" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M17 13H7v-2h10m-5-9A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2z" fill="currentColor"/></svg><li>'+newOwner+'</li></span>');
      }
      else {
        $('#owners-default').prop('selected', true);
        window.alert('To add more owners, contact a staff member');
      }
    }
  });
  function removeOwner(owner){
    var index = coowners.indexOf(owner);
    coowners.splice(index, 1);
    $('#' + owner).remove();
    $("#owners > option[value="+owner+"]").prop('disabled', false);
  }
  $('#submit-owners').click(function(){
    if (coowners.length){
      $('#co-owners').hide("slide", { direction: "left" }, 400, function(){
        $('#review-type-content').html(claimType.name);
        $('#review-location-content').html(claimCoords['x1']+', '+claimCoords['z1']+' to '+claimCoords['x2']+', '+claimCoords['z2']);
        coowners.forEach(function(owner){
          $('#review-owners-content').append('<li>• '+owner+'</li>');
        });
        $('#review').fadeIn(400);
      })
    }
  });
  $('#submit-request').click(function(){
    var count = 0;
    $('#owners').prop('disabled', true);
    coowners.forEach(function(owner){
      $('#submit-container').after('<input type="text" name="coowners['+count+']" value="'+owner+'" style="display:none;">');
      count++;
    });

    for (const [key, value] of Object.entries(claimCoords)){
      $('#submit-container').after('<input type="text" name="coords['+key+']" value="'+value+'" style="display:none;">');
    }
    $('#type, #check-size, #shared').prop('disabled', false);
    $('#new_claim_request_form').submit();
  });
</script>
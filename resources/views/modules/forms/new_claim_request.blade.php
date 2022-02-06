<?php
use Illuminate\Support\Facades\DB;
use Collective\Html\FormFacade;
use Symfony\Component\Routing\Route;
//$availableUsers = DB::table('users')->list('discord_nickname');

?>

@if (isset($_POST['submitRequest']))
  {{Form::open(['FormController@claimRequest'])}}
@else
  {{Form::open(['name' => 'claimRequest', 'url' => '/dashboard/claim', 'method' => 'get', 'id' => 'claimRequest'])}}
@endif

<!--type-->
<div>
  <div class="flex content-center items-center justify-left">
    <span class="mr-2">{{ Form::label('type', 'Claim Type:') }}</span>
      {{ Form::select('type', ['0' => 'Spawn Home', '1' => 'Main Base', '2' => 'Shop']) }}
      {{ Form::button('<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1.5em" height="1.5em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M22 12a10 10 0 0 1-10 10A10 10 0 0 1 2 12A10 10 0 0 1 12 2a10 10 0 0 1 10 10m-12 6l6-6l-6-6l-1.4 1.4l4.6 4.6l-4.6 4.6L10 18z" fill="currentColor"/></svg>', ['class' => 'text-sky-600 ml-2', 'id' => 'submit-type']) }}
  </div>
</div><br>

<!--location-->
<div>
  <span class="block mr-2 invisible">{{ Form:: label('location', 'Enter a coordinate in your center chunk')}}
</div>

<!--owners-->


<!--javascript-->
<script>
  $('#submit-type').click(function(){
    $('#submit-type).hide();
  });
</script>
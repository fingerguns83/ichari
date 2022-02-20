<?php
  $timezonesRaw = timezone_identifiers_list();
  foreach ($timezonesRaw as $tz){
    $timezones[$tz] = str_replace('_', ' ', $tz);
  }
  array_pop($timezones);
  array_unshift($timezones, 'UTC');

?>
<div class="flex content-center items-center">
<span>Timezone: </span>
{!! Form::select('timezone', $timezones, $user->timezone, ['id' => 'user-timezone', 'class' => 'w-3/5 dark:bg-slate-600 ml-2 truncate']) !!}
</div>


<script>
$('#user-timezone').change(function(){
  var element = $(this);
  $(this).css({'color': 'gold', 'font-style': 'italic'});
  var timezone = encodeURIComponent($(this).val());
  var url = "/api/users/modify?key=timezone&value="+timezone+"&user_id={{Auth::id()}}";
  $.get(url, function(){
    element.css({'color': '', 'font-style': ''});
  });
});
</script>
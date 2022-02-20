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
<div class="w-full flex content-center items-center justify-between mt-4">
  <span>RSS Notification Feed:</span>
  <span id="rss-url" class="text-lg ml-2 hover:cursor-pointer" onclick='copyRSSToClipboard()'>/notifications/{{$user->username}}-{{$user->rss_key}}</span>
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
function copyRSSToClipboard(){
  var base = "{{getenv('APP_URL')}}";
  var url = base + $('#rss-url').text();
  navigator.clipboard.writeText(url);
  alert("Copied text to clipboard: " + url);

}
</script>
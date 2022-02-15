<?php
$users = DB::table('users')
  ->select('id', 'username', 'avatar', 'perm_level', 'is_admin', 'is_banned')
  ->get();
?>

@foreach ($users as $user)
  @include('/layouts/items/card', ['card' => 'user_card', 'id' => 'user-container'])
@endforeach

<script>
  function banUser(user){
    var url = '/api/users/modify?key=is_banned&value=1&user_id='+user;
    $.get(url, function(){
      location.reload();
    });
  }
  function unbanUser(user){
    var url = '/api/users/modify?key=is_banned&value=0&user_id='+user;
    $.get(url, function(){
      location.reload();
    });
  }
  $("[id^=perm-select-]").change(function(){
    var id = $(this).prop('id').replace('perm-select-', '');
    var perm = $(this).val();
    $(this).css({'color': 'gold', 'font-style': 'italic'});
    var url = '/api/users/modify?key=perm_level&value='+perm+'&user_id='+id;
    $.get(url, function(){
      location.reload();
    });
  });
  /*$('#user-search').keyup(function(){
    var search = $(this).val().toLowerCase();
    if (search){
      $('#user-container').children("[id*="+search+"]").each(function(){
        $(this).show();
      });
      $('#user-container > div').not("[id*="+search+"]").each(function(){
        $(this).parent().hide();
      });
      
    }
    else {
      $('#user-container > div').show();
    }
  });*/
</script>
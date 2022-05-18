<?php
use App\Models\User;
$users = User::orderBy('perm_level', 'desc')->get();
?>
<div class="flex content-center justify-center h-3/4 px-12 mt-12">
  <div class="border-4 dark:border-0 rounded-2xl border-gray-500 bg-[#1b1c1d] overflow-y-scroll scrollbar-hide">
    @foreach ($users as $user)
      @include('/layouts/components/list_item', ['format' => 'user_list', 'class' => 'user-container'])
    @endforeach
  </div>
</div>

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
  $('#user-search').keyup(function(){
    var search = $(this).val().toLowerCase();
    if (search !== ""){
      if (search[0] == "@"){
        var tagsearch = search.substring(1);

        $("[id*=perm-select-").each(function(){
          if ($(this).find(':selected').text().toLowerCase().includes(tagsearch)){
            $(this).parents('.user-container').show();
          }
          else {
            $(this).parents('.user-container').hide();
          }
        });
        /*$('.user-container > div').not("[id*="+search+"]").each(function(){
          $(this).parent().hide();
        });*/
      }
      else {
        $("[id*="+search+"]").each(function(){
          $(this).parent().show();
        });
        $('.user-container > div').not("[id*="+search+"]").each(function(){
          $(this).parent().hide();
        });
      }
    }
    else {
      $('.user-container').each(function(){
        $(this).show();
      });
    }
  });
</script>
<?php
$perms = DB::table('permissions')
  ->where('id', '>', 0)
  ->get();

foreach ($perms as $perm){
  $permissions[$perm->id] = ucwords($perm->name);
}

?>
<div id="{{strtolower($user->username)}}">
  <div id="heading" class="h-16 flex flex-col w-full px-6 justify-center bg-sky-200 dark:bg-sky-700 border-b-2 border-y-slate-200 rounded-t-2xl">
    <div class="flex justify-center text-3xl font-semibold">{{$user->username}}</div>
  </div>
  <div class="flex flex-col w-full py-6 text-xl">
    <div class="flex justify-center">
      <img class="rounded-full border-2 dark:border-slate-200" src="{{$user->avatar}}" width="96">
    </div>
    <div class="flex flex-col mt-6 justify-center content-center items-center">
      <div>
        <span>Perm Level: </span>
      @if ($user->is_admin)
        {!! Form::select('admin_lock', ['0' => 'Site Admin'], 0, ['class' => 'ml-2 dark:bg-slate-600 text-gray-600 dark:text-gray-300 italic', 'disabled']) !!}    
        </div>
      @else
        {!! Form::select('perm_level', $permissions, $user->perm_level, ['id' => "perm-select-".$user->id, 'class' => 'ml-2 dark:bg-slate-600']) !!}    
        </div>
        <div class="mt-6">
          @if ($user->is_banned)
            <button class="px-2 py-1 flex content-center items-center justify-center text-2xl border-2 border-green-600 rounded-xl active:border-green-700 active:bg-green-500 active:bg-opacity-20" onclick="unbanUser('{{$user->id}}')">Unban User</button>    
          @else
            <button class="px-2 py-1 flex content-center items-center justify-center text-2xl border-2 border-red-600 rounded-xl active:border-red-700 active:bg-red-500 active:bg-opacity-20" onclick="banUser('{{$user->id}}')">Ban User</button>    
          @endif
        </div>
      @endif
    </div>
  </div>
</div>
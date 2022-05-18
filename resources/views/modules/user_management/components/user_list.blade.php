<?php
$perms = DB::table('permissions')
  ->where('id', '>', 0)
  ->get();

foreach ($perms as $perm){
  $permissions[$perm->id] = ucwords($perm->name);
}

?>
<div id="{{strtolower($user->username)}}" class="w-full grid grid-cols-12">
  <div class="flex col-span-5 content-center items-center">
    <img class="rounded-full border border-slate-200" src="{{$user->avatar}}" width="32">
    <span class="ml-2 text-2xl font-semibold">{{$user->username}}</span>
  </div>
  <div class="flex col-span-3 text-xl content-center items-center">
    <span>Perm: </span>
    @if ($user->is_admin)
      {!! Form::select('admin_lock', ['0' => 'Site Admin'], 0, ['id' => 'perm-select-'.$user->id, 'class' => 'ml-2 dark:bg-slate-600 text-gray-600 dark:text-gray-300 italic', 'disabled']) !!}
    @else
      {!! Form::select('perm_level', $permissions, $user->perm_level, ['id' => "perm-select-".$user->id, 'class' => 'ml-2 dark:bg-slate-600']) !!}
    @endif
  </div>
  <div class="flex col-span-2 col-end-13 content-center items-center justify-center">
    @if (!$user->is_admin)
      @if ($user->is_banned)
        <button class="px-2 py-1 flex content-center items-center justify-center text-xl border-2 border-green-600 rounded-xl active:border-green-700 active:bg-green-500 active:bg-opacity-20" onclick="unbanUser('{{$user->id}}')">Unban User</button>    
      @else
        <button class="px-2 py-1 flex content-center items-center justify-center text-xl border-2 border-red-600 rounded-xl active:border-red-700 active:bg-red-500 active:bg-opacity-20" onclick="banUser('{{$user->id}}')">Ban User</button>    
      @endif
    @else
      <span class="px-2 py-1 flex content-center items-center justify-center text-xl italic border-2 border-black dark:border-gray-300 dark:text-gray-300 rounded-xl">Ban User</button>    
    @endif
  </div>
</div>
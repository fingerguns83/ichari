<?php
$sections = DB::table('sections')
  ->select('name', 'icon')
  ->where('requires_team', '<=', $userMaxPerm->team_id)
  ->get();
?>

@foreach ($sections as $section)
<div class="block group h-12 text-3xl">
  <a href="/section/{{$section->name}}" class="cursor-default">
    @if ($show == $section->name)
      <div class="bg-sky-700 px-4 w-full">    
    @else
      <div class="group-hover:bg-sky-800 px-4 w-full">  
    @endif
        <svg class="inline -mt-2" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1.125em" height="1.125em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="{{$section->icon}}" fill="currentColor"/></svg>
        {{ucwords(str_replace('_', ' ', $section->name))}}
      </div>
  </a>
</div>   
@endforeach



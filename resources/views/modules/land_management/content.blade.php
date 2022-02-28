<?php
$sections = ['dimensions', 'areas', 'claim_types', 'claims'];
?>
@includeIf('/layouts/dialog', ['dialog' => 'add_land', 'dialogId' => 'addLand'])
@foreach($sections as $section)
  @includeIf('/modules/land_management/components/section', ['sectionName' => $section])
@endforeach

<script>
  $('[id$=expand]').click(function(){
    var sections = ['dimensions', 'areas', 'claim_types', 'claims'];
    var selected = $(this).attr('id').replace('-expand', '');
    var other = sections.filter(section => section !== selected);
    console.log(other);
    other.forEach(function(section){
      $('#'+section+'-details').hide();
      $('#'+section+'-expand').find('g').attr('transform', 'rotate(0 12 12)');
    });


    $('#'+selected+'-details').toggle();
    var iconRotation = $(this).children('g').attr('transform');
    iconRotation = iconRotation.replace("rotate(", '').replace(')', '').split(" ");
    if (iconRotation[0] == 180){
      $(this).children('g').attr('transform', 'rotate(0 12 12)');
    }
    else {
      $(this).children('g').attr('transform', 'rotate(180 12 12)');
    }
  
  })
</script>
<script>
  $('[id^=add-').click(function(){
    var sectionID = '#' + $(this).attr('id').replace('add-', '').slice(0, -1);
    $(sectionID).show();
    $('#addLand').show();
  });
</script>
<?php
  $sections = ['dimensions', 'areas', 'claim_types', 'administrative_claims', 'claims'];
?>
<div class="flex content-center justify-center h-9/12 mt-8 px-12">
  <div class="w-1/2 h-full flex-col overflow-y-scroll scrollbar-hide">
    @includeIf('/layouts/dialog', ['dialog' => 'add_land', 'dialogId' => 'addLand'])
    @foreach($sections as $section)
      @includeIf('/modules/land_management/components/section', ['sectionName' => $section])
    @endforeach
  </div>
</div>
<script>
  $('[id$=expand]').click(function(){
    var sections = ['dimensions', 'areas', 'claim_types', 'administrative_claims', 'claims'];
    var selected = $(this).attr('id').replace('-expand', '');
    var other = sections.filter(section => section !== selected);
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
    var sectionID = $(this).attr('id').replace('add-', '').slice(0, -1);
    var sectionTitle = sectionID.replace('_', ' ');
    var sectionTitle = sectionTitle.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()});
    $('#addLand #dialog-title').html('Add '+sectionTitle);
    $('#'+sectionID).show();
    $('#addLand').show();
  });
  $('[id^=view-').click(function(){
    console.log($(this).attr('id'));
  });
  $('[id^=edit-').click(function(){
    console.log($(this).attr('id'));
  });
</script>
var $j = jQuery, pcl, number, type, space;
type = wpvisr_ajax_object.wpvisr_type;
scale = wpvisr_ajax_object.scale;
function initiate()
{
    
    $j(".wpvisr_rating_piece").mouseenter(function(event)
    {
        rating_wroking = wpvisr_ajax_object.rating_working;
        pcl = [];
        numb = event.target.id;
        numb = (parseInt(numb.replace('wpvisr_piece_', '')));
        for (var i = 1; i <= scale; i++) {
            pcl[i] = ($j("#wpvisr_piece_" + i).attr('class')).replace('wpvisr_rating_piece ', '');
        }
        for (var i = 1; i <= scale; i++) {
            $j("#wpvisr_piece_" + i).addClass('wpvisr_' + type + '_empty');
        }
        $j(".wpvisr_rating_piece").removeClass('wpvisr_' + type + '_full_voting');
        $j(".wpvisr_rating_piece").removeClass('wpvisr_' + type + '_half_voting');
        for (i = 1; i <= numb; i++) {
            $j("#wpvisr_piece_" + i).addClass('wpvisr_' + type + '_full_voted');
        }
    }).mouseleave(function() {
        $j(".wpvisr_rating_piece").removeClass('wpvisr_' + type + '_full_voted');
        $j(".wpvisr_rating_piece").removeClass('wpvisr_' + type + '_half_voted');
        for (var i = 1; i <= scale; i++) {
            $j("#wpvisr_piece_" + i).addClass(pcl[i]);
        }
    }
    );
    
    $j(function() {
    $j( "#tabs" ).tabs();
  });
	 
$j("#wpvisr_shape").change(function(event)
{
    for (var i = 1; i <= scale; i++) {
        $j("#wpvisr_piece_" + i).removeClass('wpvisr_' + type + '_empty');
    }
    $j(".wpvisr_rating_piece").removeClass('wpvisr_' + type + '_full_voting');
    $j(".wpvisr_rating_piece").removeClass('wpvisr_' + type + '_half_voting');
    for (i = 1; i <= scale; i++) {
        $j("#wpvisr_piece_" + i).removeClass('wpvisr_' + type + '_full_voting');
    }
    type = $j("#wpvisr_color option:selected").val() + $j("#wpvisr_shape option:selected").val();
    for (i = 1; i <= scale; i++) {
        $j("#wpvisr_piece_" + i).addClass('wpvisr_' + type + '_full_voting');
    }
})

$j("#wpvisr_color").change(function(event)
{
    for (var i = 1; i <= scale; i++) {
        $j("#wpvisr_piece_" + i).removeClass('wpvisr_' + type + '_empty');
    }
    $j(".wpvisr_rating_piece").removeClass('wpvisr_' + type + '_full_voting');
    $j(".wpvisr_rating_piece").removeClass('wpvisr_' + type + '_half_voting');
    for (i = 1; i <= scale; i++) {
        $j("#wpvisr_piece_" + i).removeClass('wpvisr_' + type + '_full_voting');
    }
    type = $j("#wpvisr_color option:selected").val() + $j("#wpvisr_shape option:selected").val();
    for (i = 1; i <= scale; i++) {
        $j("#wpvisr_piece_" + i).addClass('wpvisr_' + type + '_full_voting');
    }
})
$j("#wpvisr_alignment").change(function(event)
{
    $j("#wpvisr_container").css('text-align', $j("#wpvisr_alignment option:selected").val());
})

$j("#wpvisr_scale").on('input', function(event)
{
    scale = $j("#wpvisr_scale").val();
    if (scale >= 3 && scale <= 10) {

        $j("#wpvisr_shapes").html('');
        for (i = 1; i <= scale; i++) {
            $j("#wpvisr_shapes").html($j("#wpvisr_shapes").html() + '<span id="wpvisr_piece_' + i + '" class="wpvisr_rating_piece wpvisr_' + type + '_full_voting"></span>');
            $j("#wpvisr_piece_" + i).addClass();
        }
        initiate();
    }
    else {
        $j("#wpvisr_shapes").html('');
        for (i = 1; i <= 5; i++) {
            $j("#wpvisr_shapes").html($j("#wpvisr_shapes").html() + '<span id="wpvisr_piece_' + i + '" class="wpvisr_rating_piece wpvisr_' + type + '_full_voting"></span>');
            $j("#wpvisr_piece_" + i).addClass();
        }
        initiate();
    }
})
$j("#wpvisr_show_vote_count").change(function(event)
{
    
    if ($j(this).is(":checked")) {
    	$j("#wpvisr_votes").remove('#wpvisr_votes');
        $j("#wpvisr_shapes").append('<span id="wpvisr_votes"></span>');
        $j("#wpvisr_votes").html('5 votes');
    }
    else
        $j("#wpvisr_votes").remove('#wpvisr_votes');
})
}
$j('.feedback').click(function ()
{
	$feedback_email = $j('#feedback_email').val();
	if($feedback_email =='')
	{
			$j('#feedback_email').focus();
	}
	
	$feedback_value= $j('#feedback_subject').val();
	if($feedback_value =='')
	{
			$j('#feedback_subject').focus();
	} 
	
	$feedback_comment= $j('#feedback_comment').val();
	if($feedback_comment =='')
	{
			$j('#feedback_comment').focus();
	}
	
	if($feedback_value !=''&& $feedback_comment !='' && $feedback_email !='')
	{
		$j('$feedback_form').submit();
	}
	else
	{
		alert("Please Fill the Required Fields");
		if($feedback_value =='')
		{
			$j('#feedback_subject').focus();
			return false;
		}		
		else if($feedback_comment =='')
		{
			$j('#feedback_comment').focus();
			return false;
		}
		else if($feedback_email =='')
		{
			$j('#feedback_email').focus();
			return false;
		}
		return false;	
	}	
});
jQuery(document).ready(function($) {
    initiate();
});


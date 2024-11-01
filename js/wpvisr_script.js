var $j = jQuery,
    pcl, rating_working, numb;
$j(document).ready(function() {
	//alert(wpvisr_script_ajax_object.rating_working);
    $j("#wpvisr_container_" + wpvisr_script_ajax_object.post_id).children("#wpvisr_shapes").children(".wpvisr_rating_piece").mouseenter(function(e) {
        if (rating_working = wpvisr_script_ajax_object.rating_working) {
            pcl = [], numb = e.target.id, 
            numb = parseInt(numb.replace("wpvisr_piece_", ""));
            //alert(numb);
            for (var t = 1; t <= wpvisr_script_ajax_object.scale; t++) pcl[t] = $j("#wpvisr_piece_" + t).attr("class").replace("wpvisr_rating_piece ", "");
            for (var t = 1; t <= wpvisr_script_ajax_object.scale; t++) $j("#wpvisr_piece_" + t).addClass("wpvisr_" + wpvisr_script_ajax_object.wpvisr_type + "_empty");
            for ($j("#wpvisr_container_" + wpvisr_script_ajax_object.post_id).children("#wpvisr_shapes").children(".wpvisr_rating_piece").removeClass("wpvisr_" + wpvisr_script_ajax_object.wpvisr_type + "_full_voting"),$j("#wpvisr_container_" + wpvisr_script_ajax_object.post_id).children("#wpvisr_shapes").children(".wpvisr_rating_piece").removeClass("wpvisr_" + wpvisr_script_ajax_object.wpvisr_type + "_half_voting"), t = 1; numb >= t; t++) 
            $j("#wpvisr_piece_" + t).addClass("wpvisr_" + wpvisr_script_ajax_object.wpvisr_type + "_full_voted")
        }
    }).mouseleave(function() {
        if (rating_working) {
            $j("#wpvisr_container_" + wpvisr_script_ajax_object.post_id).children("#wpvisr_shapes").children(".wpvisr_rating_piece").removeClass("wpvisr_" + wpvisr_script_ajax_object.wpvisr_type + "_full_voted"), $j("#wpvisr_container_" + wpvisr_script_ajax_object.post_id).children("#wpvisr_shapes").children(".wpvisr_rating_piece").removeClass("wpvisr_" + wpvisr_script_ajax_object.wpvisr_type + "_half_voted");
            for (var e = 1; e <= wpvisr_script_ajax_object.scale; e++) $j("#wpvisr_piece_" + e).addClass(pcl[e])
        }
    }), $j("#wpvisr_container_" + wpvisr_script_ajax_object.post_id).children("#wpvisr_shapes").children(".wpvisr_rating_piece").click(function(e) {
        rating_working = wpvisr_script_ajax_object.rating_working,numb = e.target.id,numb = parseInt(numb.replace("wpvisr_piece_", "")), 
        request = {
            post_id: wpvisr_script_ajax_object.post_id,
            points: numb,
            action: "wpvisr_star_rating"
        }, rating_working && numb >= 1 && numb <= wpvisr_script_ajax_object.scale && $j.ajax({
            type: "post",
            dataType: "json",
            url: wpvisr_script_ajax_object.ajax_url,
            data: request,
            success: function(e) {
                if (1 == e.status) $j("#wpvisr_container_" + wpvisr_script_ajax_object.post_id).html(e.html), rating_working = !1;
                else if (2 == e.status) return !1
            }
        })
    })
})
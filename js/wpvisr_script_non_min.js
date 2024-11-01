var $j = jQuery, pcl, rating_working, numb;
$j( document ).ready(function() {
$j("#wpvisr_container_" + wpvisr_script_ajax_object.post_id).children("#wpvisr_shapes").children(".wpvisr_rating_piece").mouseenter(function(r) {
    if (rating_working = wpvisr_script_ajax_object.rating_working) {
        pcl = [], numb = r.target.id, numb = parseInt(numb.replace("wpvisr_piece_", ""));
        for (var _ = 1; _ <= wpvisr_script_ajax_object.scale; _++)
            pcl[_] = $j("#wpvisr_piece_" + _).attr("class").replace("wpvisr_rating_piece ", "");
        for (var _ = 1; _ <= wpvisr_script_ajax_object.scale; _++)
            $j("#wpvisr_piece_" + _).addClass("wpvisr_" + wpvisr_script_ajax_object.wpvisr_type + "_empty");
        for ($j("#wpvisr_container_" + wpvisr_script_ajax_object.post_id).children("#wpvisr_shapes").children(".wpvisr_rating_piece").removeClass("wpvisr_" + wpvisr_script_ajax_object.wpvisr_type + "_full_voting"), $j("#wpvisr_container_" + wpvisr_script_ajax_object.post_id).children("#wpvisr_shapes").children(".wpvisr_rating_piece").removeClass("wpvisr_" + wpvisr_script_ajax_object.wpvisr_type + "_half_voting"), _ = 1; numb >= _; _++)
            $j("#wpvisr_piece_" + _).addClass("wpvisr_" + wpvisr_script_ajax_object.wpvisr_type + "_full_voted")
    }
}).mouseleave(function() {
    if (rating_working) {
        $j("#wpvisr_container_" + wpvisr_script_ajax_object.post_id).children("#wpvisr_shapes").children(".wpvisr_rating_piece").removeClass("wpvisr_" + wpvisr_script_ajax_object.wpvisr_type + "_full_voted"), $j("#wpvisr_container_" + wpvisr_script_ajax_object.post_id).children("#wpvisr_shapes").children(".wpvisr_rating_piece").removeClass("wpvisr_" + wpvisr_script_ajax_object.wpvisr_type + "_half_voted");
        for (var r = 1; r <= wpvisr_script_ajax_object.scale; r++)
            $j("#wpvisr_piece_" + r).addClass(pcl[r])
    }
}), $j("#wpvisr_container_" + wpvisr_script_ajax_object.post_id).children("#wpvisr_shapes").children(".wpvisr_rating_piece").click(function(r) {
    rating_working = wpvisr_script_ajax_object.rating_working, numb = r.target.id, numb = parseInt(numb.replace("wpvisr_piece_", "")), request = {post_id: wpvisr_script_ajax_object.post_id, points: numb, action: "wpvisr_rate"}, rating_working && numb >= 1 && numb <=wpvisr_script_ajax_object.scale && $j.ajax({type: "post", dataType: "json", url: wpvisr_script_ajax_object.ajax_url, data: request, success: function(r) {
            if (1 == r.status)
                $j("#wpvisr_container_" + wpvisr_script_ajax_object.post_id).html(r.html), rating_working = !1;
            else if (2 == r.status)
                return!1
        }})
});
});
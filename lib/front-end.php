<?php
function programmatic_seo_header_metadata() {
    try{
        global $post;
        $programmatic_seo_keywords = '';
        $programmatic_seo_description = '';
        if(isset($post->ID)){
             $programmatic_seo_keywords = get_post_meta($post->ID,'_programmatic_seo_keyword',true);
             $programmatic_seo_description = get_post_meta($post->ID,'_programmatic_seo_description',true);
            if(empty($programmatic_seo_keywords)){
                $programmatic_seo_keywords = get_post_meta($post->ID,'rank_math_focus_keyword',true);
            }
            if(empty($programmatic_seo_keywords)){
                $programmatic_seo_description = get_post_meta($post->ID,'rank_math_description',true);
            }
        }
        if(!empty($programmatic_seo_keywords)){
            echo '<meta name="keywords" content="'.$programmatic_seo_keywords.'" />';
        }
        if(!empty($programmatic_seo_description)){
            echo '<meta name="description" content="'.$programmatic_seo_description.'" />';
        }
    }
    catch(Exception $e){}
}
add_action( 'wp_head', 'programmatic_seo_header_metadata',1 );

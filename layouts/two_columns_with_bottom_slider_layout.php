<?php
$php_contents = <<<EOT
<?php

    global \$wpdb;
    global \$wp_query;

    \$table_name = FIXEDLY_MEDIA_DB_TABLE;
    \$table_name_2 = FIXEDLY_GALLERY_DB_TABLE;

    \$rows_affected = \$wpdb->get_results("SELECT \$table_name.* FROM \$table_name, \$table_name_2
        WHERE \$table_name.gid = '" . \$gid . "'
        AND \$table_name.status = 'visible'
        AND \$table_name_2.status = 'visible'
        AND \$table_name_2.type = '" . \$type . "'
        AND \$table_name.gid = \$table_name_2.id
        AND \$table_name_2.status = 'visible'");

    if (!empty(\$rows_affected)) {
    
        \$show_media_title = "show";
        \$show_media_description = "show";
        \$show_media_nav = "show";
?>

<div class="fixedly-cont-<?php print \$wp_query->post->ID;?>">

    <div class="fixedly-top-cont">
    
        <div class="fixedly-top-left" style="width: {$rows_affected[0]->col_left_width}px;">
        
            <select id="vid-cont" name="" onchange="addVideoSelect(this.options[this.selectedIndex].value);">
                <option value="">-- Select Video --</option>
                <?php for (\$row = 0; \$row < sizeof(\$rows_affected); \$row++): ?>
                <option value="<?php print \$rows_affected[\$row]->link;?>|<?php print \$rows_affected[\$row]->title;?>|<?php print \$rows_affected[\$row]->description;?>|100%|{$rows_affected[0]->col_height}px"><?php print \$rows_affected[\$row]->title ;?></option>
                <?php endfor;?>
            </select>

            <?php if (\$show_media_title == "{$rows_affected[0]->show_media_title}"): ?>
            <div class="fixedly-inner-head"><?php print \$rows_affected[\$row]->title;?></div>
            <?php endif;?>

            <?php if (\$show_media_description == "{$rows_affected[0]->show_media_description}"): ?>
            <div class="fixedly-inner-text"><?php print \$rows_affected[\$row]->description;?></div>
            <?php endif;?>
        </div>
        <div class="fixedly-top-right" style="width: {$rows_affected[0]->col_right_width}px;"></div>
    </div>
    
    <div class="fixedly-bot-cont">
    
        <div class="fixedly-bot-slider">
        
            <div class="fixedly-bot-slider-cont-<?php print \$wp_query->post->ID;?>">
                <ul>
                    <?php for (\$row = 0; \$row < sizeof(\$rows_affected); \$row++): ?>

                    <li><a href="javascript:void();" onclick="addVideo('<?php print \$rows_affected[\$row]->link;?>','<?php print \$rows_affected[\$row]->title;?>','<?php print \$rows_affected[\$row]->description;?>','100%','{$rows_affected[0]->col_height}px')"><img src="<?php print \$rows_affected[\$row]->screenshot;?>" alt="" width="{$rows_affected[0]->screenshot_thumb_width}" height="{$rows_affected[0]->screenshot_thumb_height}" /></a>

                    <?php if (\$row % 1 == 0 && \$row != 0 ) print "</ul><ul>";?>
                    <?php endfor;?>
                </ul>
            </div>
            
            <div class="fixedly-inner-nav-prev-<?php print \$wp_query->post->ID;?>"><a href="javascript:void();">{$rows_affected[0]->nav_prev_text}</a></div>
            <div class="fixedly-inner-nav-next-<?php print \$wp_query->post->ID;?>"><a href="javascript:void();">{$rows_affected[0]->nav_next_text}</a></div>
        </div>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){

    jQuery('.fixedly-bot-slider-cont-<?php print \$wp_query->post->ID;?>').cycle({
        fx: '{$rows_affected[0]->script_cycle_fx}',
        fit: 'true',
        width: '{$rows_affected[0]->script_cycle_width}',
        height: '{$rows_affected[0]->script_cycle_height}',
        speed: '{$rows_affected[0]->script_cycle_speed}',
        random: '{$rows_affected[0]->script_cycle_random}',
        pause: '{$rows_affected[0]->script_cycle_pause}',
        delay: '{$rows_affected[0]->script_cycle_delay}',
        continuous: '{$rows_affected[0]->script_cycle_continuous}',
        timeout: '{$rows_affected[0]->script_cycle_timeout}',
        prev: '.fixedly-inner-nav-prev-<?php print \$wp_query->post->ID;?> a',
        next: '.fixedly-inner-nav-next-<?php print \$wp_query->post->ID;?> a'
    });

    <?php for (\$row = 0; \$row < 1; \$row++) : ?>
    jQuery('.fixedly-top-right').html('<iframe src="<?php print \$rows_affected[\$row]->link;?>" width="100%" height="{$rows_affected[0]->col_height}px" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>');
    jQuery('.fixedly-inner-head').html('<?php print \$rows_affected[\$row]->title;?>');
    jQuery('.fixedly-inner-text').html('<?php print \$rows_affected[\$row]->description;?>');
    <?php endfor; ?>
});

function addVideo(vidURL, vidTitle, vidText, vidWidth, vidHeight) {

    jQuery(document).ready(function(){
    
        jQuery('.fixedly-top-right').html('<iframe src="' + vidURL + '" width="' + vidWidth + '" height="' + vidHeight + '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>');
        jQuery('.fixedly-inner-head').html(vidTitle);
        jQuery('.fixedly-inner-text').html(vidText);
    });
}

function addVideoSelect(vidContent) {

    vidContent = vidContent.split('|');
    
    jQuery(document).ready(function(){
    
        jQuery('.fixedly-top-right').html('<iframe src="' + vidContent[0] + '" width="' + vidContent[3] + '" height="' + vidContent[4] + '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>');
        jQuery('.fixedly-inner-head').html(vidContent[1]);
        jQuery('.fixedly-inner-text').html(vidContent[2]);
    });
}
</script>
<style type="text/css">
.fixedly-cont-<?php print \$wp_query->post->ID;?> {{$rows_affected[0]->style_fixedly_cont}}
.fixedly-inner-nav-<?php print \$wp_query->post->ID;?> {{$rows_affected[0]->style_fixedly_inner_nav}}
.fixedly-inner-nav-prev-<?php print \$wp_query->post->ID;?> {{$rows_affected[0]->style_fixedly_inner_nav_prev}}
.fixedly-inner-nav-next-<?php print \$wp_query->post->ID;?> {{$rows_affected[0]->style_fixedly_inner_nav_next}}
.fixedly-inner-head {{$rows_affected[0]->style_fixedly_inner_head}}
.fixedly-inner-text {{$rows_affected[0]->style_fixedly_inner_text}}
.fixedly-top-cont {{$rows_affected[0]->style_fixedly_top_cont}}
.fixedly-top-left {{$rows_affected[0]->style_fixedly_top_left}}
.fixedly-top-left select {{$rows_affected[0]->style_fixedly_top_left_select}}
.fixedly-top-right {{$rows_affected[0]->style_fixedly_top_right}}
.fixedly-top-right iframe {{$rows_affected[0]->style_fixedly_top_right_iframe}}
.fixedly-bot-cont {{$rows_affected[0]->style_fixedly_bot_cont}}
.fixedly-bot-slider-<?php print \$wp_query->post->ID;?> {{$rows_affected[0]->style_fixedly_bot_slider}}
.fixedly-bot-slider-cont-<?php print \$wp_query->post->ID;?> {{$rows_affected[0]->style_fixedly_bot_slider_cont}}
.fixedly-bot-slider-cont-<?php print \$wp_query->post->ID;?> ul {{$rows_affected[0]->style_fixedly_bot_slider_cont_ul}}
.fixedly-bot-slider-cont-<?php print \$wp_query->post->ID;?> ul li {{$rows_affected[0]->style_fixedly_bot_slider_cont_ul_li}}
.fixedly-bot-slider-cont-<?php print \$wp_query->post->ID;?> ul li img {{$rows_affected[0]->style_fixedly_bot_slider_cont_ul_li_img}}
</style>

<?php

    }
    else
        print "<p><em>[Fixedly Error #3]: You need to createa Fixedly Gallery & Add Images/Videos/Slideshow!</em></p>";
?>
EOT;
?>

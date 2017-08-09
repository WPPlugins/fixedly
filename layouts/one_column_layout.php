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

    <?php if (\$show_media_nav == "{$rows_affected[0]->show_media_nav}"): ?>
    <div class="fixedly-inner-nav-<?php print \$wp_query->post->ID;?>" style="width: {$rows_affected[0]->col_width}px;">
        <div class="fixedly-inner-nav-prev-<?php print \$wp_query->post->ID;?>"><a href="javascript:void();">{$rows_affected[0]->nav_prev_text}</a></div>
        <div class="fixedly-inner-nav-next-<?php print \$wp_query->post->ID;?>"><a href="javascript:void();">{$rows_affected[0]->nav_next_text}</a></div>
    </div>
    <?php endif;?>

    <div class="fixedly-inner-cont-<?php print \$wp_query->post->ID;?>">
        
        <?php for (\$row = 0; \$row < sizeof(\$rows_affected); \$row++) : ?>
        
        <div class="fixedly-inner-<?php print \$wp_query->post->ID;?>">
        
            <img src="<?php print \$rows_affected[\$row]->link;?>" alt="<?php print \$rows_affected[\$row]->title;?>" style="width: <?php print '{$rows_affected[0]->col_width}px';?>; height: <?php print '{$rows_affected[0]->col_height}px';?>" />
            
            <?php if (\$show_media_title == "{$rows_affected[0]->show_media_title}"): ?>
            <div class="fixedly-inner-head"><?php print \$rows_affected[\$row]->title;?></div>
            <?php endif;?>
            
            <?php if (\$show_media_description == "{$rows_affected[0]->show_media_description}"): ?>
            <div class="fixedly-inner-text"><?php print \$rows_affected[\$row]->description;?></div>
            <?php endif;?>
        </div>
        
        <?php endfor;?>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){

    jQuery('.fixedly-inner-cont-<?php print \$wp_query->post->ID;?>').cycle({
    
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
});
</script>
<style type="text/css">
.fixedly-cont-<?php print \$wp_query->post->ID;?> {{$rows_affected[0]->style_fixedly_cont}}
.fixedly-inner-nav-<?php print \$wp_query->post->ID;?> {{$rows_affected[0]->style_fixedly_inner_nav}}
.fixedly-inner-nav-prev-<?php print \$wp_query->post->ID;?> {{$rows_affected[0]->style_fixedly_inner_nav_prev}}
.fixedly-inner-nav-next-<?php print \$wp_query->post->ID;?> {{$rows_affected[0]->style_fixedly_inner_nav_next}}
.fixedly-inner-cont-<?php print \$wp_query->post->ID;?> {{$rows_affected[0]->style_fixedly_inner_cont}}
.fixedly-inner-<?php print \$wp_query->post->ID;?> {{$rows_affected[0]->style_fixedly_inner}}
.fixedly-inner-<?php print \$wp_query->post->ID;?> img {{$rows_affected[0]->style_fixedly_inner_img}}
.fixedly-inner-head {{$rows_affected[0]->style_fixedly_inner_head}}
.fixedly-inner-text {{$rows_affected[0]->style_fixedly_inner_text}}
</style>

<?php

    }
    else
        print "<p><em>[Fixedly Error #3]: You need to createa Fixedly Gallery & Add Images/Videos/Slideshow!</em></p>";
?>
EOT;
?>

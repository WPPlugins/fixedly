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

<?php

    }
    else
        print "<p><em>[Fixedly Error #3]: You need to createa Fixedly Gallery & Add Images/Videos/Slideshow!</em></p>";
?>
EOT;
?>

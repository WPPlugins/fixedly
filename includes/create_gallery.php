<div class="fixedly-wrap">

    <h3>Fixedly / Create &amp; Manage Galleries</h3>

    <h4>1. Add New Gallery</h4>

    <form id="add-new-gallery" method="post" action="<?php print__FILE__;?>">
        <?php settings_fields('settings-group'); ?>
        <table id="ftable" cellspacing="1">
            <tr>
                <th>Gallery Name</th>
                <th class="aleft">Gallery Type</th>
                <th class="aleft">Gallery Template</th>
            </tr>
            <tr>
                <td>
                    <input type="text" name="title" value="" class="ftxt required" maxlength="128" /><br />
                    <span><em>Your need to enter Name for your new gallery (cannot exceed 128 characters).</em></span><br />
                </td>
                <td>
                    <select name="type" class="required">
                        <option value="">-- choose one --</option>
                        <option value="image">image</option>
                        <option value="video">video</option>
                        <option value="slideshow">slideshow</option>
                    </select><br />
                    <span><em>You need to select the Type for your gallery.</em></span><br />
                </td>
                <td>
                    <select name="template" class="required">
                        <option value="">-- choose one --</option>
                        <?php select_templates();?>
                    </select><br />
                    <span><em>You need to select a the Template, look &amp; feel, for your gallery.</em></span><br />
                </td>
            </tr>
        </table>

        <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Add New Gallery') ?>" /></p>
    </form>

    <h4>2. Manage Galleries</h4>

    <?php if ($success != false) :?><p class="success"><strong><?php print $success;?></strong></p><?php endif;?>

    <table id="ftable" cellspacing="1">
        <tr>
            <th>Gallery ID</th>
            <th>Gallery # Entries</th>
            <th class="aleft">Gallery Name</th>
            <th nowrap>Gallery Type</th>
            <th nowrap>Gallery Template</th>
            <th nowrap>Current Status</th>
            <th nowrap>Update Gallery Status</th>
            <th nowrap>Created On</th>
        </tr>
        <?php select_galleries();?>
    </table>

    <?php if (!empty($_GET["gid"]) && $_GET["gallery"] == "manage"):?>

    <br />

    <h4>3. Manage Gallery Entries</h4>

    <table id="ftable" cellspacing="1">
        <tr>
            <th>Media Screenshot</th>
            <th class="aleft">Media Title</th>
            <th class="aleft">Media Description</th>
            <?php if ($_GET["type"] == "slideshow"):?>
            <th class="aleft">Slider URL</th>
            <?php endif;?>
            <th nowrap>Media URL</th>
            <th nowrap>Media Type</th>
            <th nowrap>Current Status</th>
            <th nowrap>Update Media Status</th>
            <th nowrap>Created On</th>
        </tr>
        <?php select_media($_GET["gid"], $_GET["type"], $_GET["cpage"]); ?>
   </table>
   
   <h4 class="acenter"><?php paginate_media($_GET["gid"], $_GET["type"], $_GET["cpage"])?></h4>

   <?php endif;?>
   
</div>

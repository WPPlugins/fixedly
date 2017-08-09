<div class="fixedly-wrap">

    <h3>Fixedly / Add New Slides</h3>

    <h4>1. Select Gallery</h4>

    <form id="add-new-slides" method="post" action="<?php print__FILE__;?>">
        <?php settings_fields('settings-group'); ?>
        <table id="ftable-top" cellspacing="1">
            <tr>
                <th class="aleft">Gallery Name</th>
            </tr>
            <tr>
                <td>
                    <select name="gid" class="required">
                        <option value="">-- choose select --</option>
                        <?php select_slideshow_galleries();?>
                    </select><br />
                    <span><em>You need to select the Gallery where you are going to add slides.</em></span>
                </td>
            </tr>
        </table>

        <h4>2. Add New Slide(s)</h4>
        
        <?php if ($success != false) :?><p class="success"><strong><?php print $success;?></strong></p><?php endif;?>

        <table id="ftable" cellspacing="1">
            <tr>
                <th>Slide Title</th>
                <th>Slide Short Description</th>
                <th>Slide URL (Link)</th>
                <th>Slide Image URL (Link)</th>
            </tr>
            <tr>
                <td><input type="text" name="title[]" value="" class="ftxt required" maxlength="255" /><br />
                    <span><em>You need to enter Title for your slide (cannot exceed 128 characters).</em></span>
                </td>
                <td><textarea name="description[]" class="fta required"></textarea></td>
                <td><input type="text" name="slide_link[]" value="" class="ftxt" maxlength="255" /><br />
                    <span><em>You need to enter URL for you slide.</em></span>
                </td>
                <td nowrap>
                    <input class="fixedly_upload_image ftxt2 required" type="text" name="upload_image[]" value="" maxlength="255" />
                    <input class="fixedly_upload_image_button" type="button" value="Upload & Attach Image" /><br />
                    <span><em>Enter your external image URL or click Upload and then Insert your image.</em></span>
                </td>
            </tr>
            <tr class="hidden-row">
                <td><input type="text" name="title[]" value="" class="ftxt required" maxlength="255" /></td>
                <td><textarea name="description[]" class="fta required"></textarea></td>
                <td><input type="text" name="slide_link[]" value="" class="ftxt" maxlength="255" /></td>
                <td>
                    <input class="fixedly_upload_image ftxt2 required" type="text" name="upload_image[]" value="" maxlength="255" />
                    <input class="fixedly_upload_image_button" type="button" value="Upload & Attach Image" />
                </td>
            </tr>
            <tr class="hidden-row">
                <td><input type="text" name="title[]" value="" class="ftxt required" maxlength="255" /></td>
                <td><textarea name="description[]" class="fta required"></textarea></td>
                <td><input type="text" name="slide_link[]" value="" class="ftxt" maxlength="255" /></td>
                <td>
                    <input class="fixedly_upload_image ftxt2 required" type="text" name="upload_image[]" value="" maxlength="255" />
                    <input class="fixedly_upload_image_button" type="button" value="Upload & Attach Image" />
                </td>
            </tr>
            <tr class="hidden-row">
                <td><input type="text" name="title[]" value="" class="ftxt required" maxlength="255" /></td>
                <td><textarea name="description[]" class="fta required"></textarea></td>
                <td><input type="text" name="slide_link[]" value="" class="ftxt" maxlength="255" /></td>
                <td>
                    <input class="fixedly_upload_image ftxt2 required" type="text" name="upload_image[]" value="" maxlength="255" />
                    <input class="fixedly_upload_image_button" type="button" value="Upload & Attach Image" />
                </td>
            </tr>
            <tr class="hidden-row">
                <td><input type="text" name="title[]" value="" class="ftxt required" maxlength="255" /></td>
                <td><textarea name="description[]" class="fta required"></textarea></td>
                <td><input type="text" name="slide_link[]" value="" class="ftxt" maxlength="255" /></td>
                <td>
                    <input class="fixedly_upload_image ftxt2 required" type="text" name="upload_image[]" value="" maxlength="255" />
                    <input class="fixedly_upload_image_button" type="button" value="Upload & Attach Image" />
                </td>
            </tr>
        </table>

        <p><a href="javascript:void();" class="add-more-rows">Add Multiple Slides...</a></p>

        <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Add New Slides') ?>" /></p>
    </form>

</div>

<div class="fixedly-wrap">

    <h3>Fixedly / Add New Videos</h3>

    <h4>1. Select Gallery</h4>

    <form id="add-new-videos" method="post" action="<?php print__FILE__;?>">
        <?php settings_fields('settings-group'); ?>
        <table id="ftable-top" cellspacing="1">
            <tr>
                <th class="aleft">Gallery Name</th>
            </tr>
            <tr>
                <td>
                    <select name="gid" class="required">
                        <option value="">-- choose one --</option>
                        <?php select_video_galleries();?>
                    </select><br />
                    <span><em>You need to select the Gallery where you are going to add videos.</em></span>
                </td>
            </tr>
        </table>

        <h4>2. Add New Video(s)</h4>
        
        <?php if ($success != false) :?><p class="success"><strong><?php print $success;?></strong></p><?php endif;?>

        <table id="ftable" cellspacing="1">
            <tr>
                <th>Video Title</th>
                <th>Video Short Description</th>
                <th>Video UID (Unique ID)</th>
            </tr>
            <tr>
                <td><input type="text" name="title[]" value="" class="ftxt required" maxlength="255" /><br />
                    <span><em>You need to enter Title for your video (cannot exceed 128 characters).</em></span></td>
                <td><textarea name="description[]" class="fta required"></textarea></td>
                <td>
                    <input type="radio" name="type[]" value="youtube" checked /> <span>YouTube &nbsp;</span>
                    <input type="radio" name="type[]" value="vimeo" /> <span>Vimeo &nbsp;</span>
                    <input type="radio" name="type[]" value="dailymotion" /> <span>Dailymotion</span><br />
                    <p><input type="text" name="link[]" value="" class="ftxt required" maxlength="255" /></p>
                    <span><em>You need to enter Unique ID for you video (cannot exceed 64 characters). E.g:</em><br /><br />
                        <strong>YouTube</strong> - http://www.youtube.com/watch?v=<strong>M_OqprX7148</strong><br />
                        <strong>Vimeo</strong> - http://vimeo.com/<strong>27299211</strong><br />
                        <strong>Dailymotion</strong> - http://www.dailymotion.com/video/<strong>xbfsu2</strong></span></td>
            </tr>
        </table>

        <p><a href="#" onclick="addNewVideoRow()">Add New Row...</a></p>

        <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Add New Videos') ?>" /></p>
    </form>

</div>

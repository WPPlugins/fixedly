<script type="text/javascript">
    jQuery(document).ready(function(){

        jQuery("select.handle1").change(function () {
        
            jQuery("#select-template").submit();
        });
        
        var handle_parts = jQuery("select.handle1 option:selected").val().split("|");
        
        var layout = handle_parts[0];
        var template = handle_parts[1]

        if (template != "" && layout != "") {
        
            jQuery(".media-table").hide();
            jQuery(".stylesheet-table").hide();
            jQuery(".scripts-table").hide();
            jQuery(".one-col").hide();
            jQuery(".two-col").hide();
            jQuery(".two-col-bot-slider").hide();
            
            if (layout != "") {

                jQuery(".media-table").show();
                jQuery(".stylesheet-table").show();
                jQuery(".scripts-table").show();
            }

            if (layout == "one-column") {

                jQuery(".one-col").show();
                <?php $rows_affected_selected = select_template_options($_POST["handle1"]);?>
            }

            if (layout == "two-columns") {

                jQuery(".two-col").show();
            }

            if (layout == "two-columns-with-bottom-slider") {

                jQuery(".two-col-bot-slider").show();
            }
        }
    });
</script>

<div class="fixedly-wrap">

    <h3>Fixedly / Edit &amp; Update Templates</h3>

    <h4>1. Select Template Name</h4>

    <?php if ($success != false) :?><p class="success"><strong><?php print $success;?></strong></p><?php endif;?>

    <form id="select-template" method="post" action="<?php print__FILE__;?>">
        <?php settings_fields('settings-group'); ?>
        <table id="ftable" cellspacing="1">
            <tr>
                <th class="aleft">Template Name</th>
            </tr>
            <tr>
                <td>
                    <select name="handle1" class="handle1">
                        <option value="">-- choose one --</option>
                        <?php print select_templates($_POST["handle1"]);?>
                    </select>
                    <span><em>You need to select the Template that you are going to update.</em></span>
                </td>
            </tr>
        </table>
    </form>

    <br />

    <?php if (!empty($_POST["handle1"])) :?>

    <h4> 2. Save Template Options</h4>

    <form id="save-template" method="post" action="<?php print__FILE__;?>">
        <input type="hidden" name="handle" value="<?php print $_POST['handle1'];?>" />
        <?php settings_fields('settings-group'); ?>

        <div class="media-table">

            <table id="ftable" cellspacing="1">
                <tr>
                    <th nowrap>Media Title</th>
                    <th nowrap>Media Description</th>
                    <th nowrap>Media Nav</th>
                    <th class="one-col">Column Width</th>
                    <th class="two-col two-col-bot-slider">Left Column Width</th>
                    <th class="two-col two-col-bot-slider">Right Column Width</th>
                    <th class="one-col two-col two-col-bot-slider">Height</th>
                    <th class="two-col-bot-slider">Screenshot Width</th>
                    <th class="two-col-bot-slider">Screenshot Height</th>
                    <th class="one-col two-col two-col-bot-slider">Nav Previous Text</th>
                    <th class="one-col two-col two-col-bot-slider">Nav Next Text</th>
                </tr>
                <tr>
                    <td nowrap class="acenter"><input type="radio" name="show_title" value="show" <?php if ($rows_affected_selected[0]->show_media_title == "show") print "checked";?> /> <span>show</span><br />
                        <input type="radio" name="show_title" value="dont_show" <?php if ($rows_affected_selected[0]->show_media_title == "dont_show") print "checked";?> /> <span>don't show</span></td>
                    <td nowrap class="acenter"><input type="radio" name="show_description" value="show" <?php if ($rows_affected_selected[0]->show_media_description == "show") print "checked";?> /> <span>show</span><br />
                        <input type="radio" name="show_description" value="dont_show" <?php if ($rows_affected_selected[0]->show_media_description == "dont_show") print "checked";?> /> <span>don't show</span></td>
                    <td nowrap class="acenter"><input type="radio" name="show_nav" value="show" <?php if ($rows_affected_selected[0]->show_media_nav == "show") print "checked";?> /> <span>show</span><br />
                        <input type="radio" name="show_nav" value="dont_show" <?php if ($rows_affected_selected[0]->show_media_nav == "dont_show") print "checked";?> /> <span>don't show</span></td>
                    <td class="one-col"><input type="text" name="tpl_col_width" class="ftxt" value="<?php if ($rows_affected_selected[0]->col_width) print $rows_affected_selected[0]->col_width;?>" maxlength="4" /><br />
                        <span><em>Enter the width of your column (px)</em></span></td>
                    <td class="two-col two-col-bot-slider"><input type="text" name="tpl_col_left_width" class="ftxt" value="<?php if ($rows_affected_selected[0]->col_left_width) print $rows_affected_selected[0]->col_left_width;?>" maxlength="4" /><br />
                        <span><em>Enter the width of your left column (px)</em></span></td>
                    <td class="two-col two-col-bot-slider"><input type="text" name="tpl_col_right_width" class="ftxt" value="<?php if ($rows_affected_selected[0]->col_right_width) print $rows_affected_selected[0]->col_right_width;?>" maxlength="4" /><br />
                        <span><em>Enter the width of your right column (px)</em></span></td>
                    <td class="one-col two-col two-col-bot-slider"><input type="text" name="tpl_col_height" class="ftxt" value="<?php if ($rows_affected_selected[0]->col_height) print $rows_affected_selected[0]->col_height;?>" maxlength="4" /><br />
                        <span><em>Enter the height of your template (px)</em></span></td>
                    <td class="two-col-bot-slider"><input type="text" name="tpl_screenshot_thumb_width" class="ftxt" value="<?php if ($rows_affected_selected[0]->screenshot_thumb_width) print $rows_affected_selected[0]->screenshot_thumb_width;?>" maxlength="4" /><br />
                        <span><em>Enter the width of your screenshot thumbnail.</em></span></td>
                    <td class="two-col-bot-slider"><input type="text" name="tpl_screenshot_thumb_height" class="ftxt" value="<?php if ($rows_affected_selected[0]->screenshot_thumb_height) print $rows_affected_selected[0]->screenshot_thumb_height;?>" maxlength="4" /><br />
                        <span><em>Enter the height of your screenshot thumbnail.</em></span></td>
                    <td class="one-col two-col two-col-bot-slider"><input type="text" name="tpl_nav_prev_text" class="ftxt" value="<?php if ($rows_affected_selected[0]->nav_prev_text) print $rows_affected_selected[0]->nav_prev_text;?>" maxlength="128" /><br />
                        <span><em>Enter your navigation Previous button text</em></span></td>
                    <td class="one-col two-col two-col-bot-slider"><input type="text" name="tpl_nav_next_text" class="ftxt" value="<?php if ($rows_affected_selected[0]->nav_next_text) print $rows_affected_selected[0]->nav_next_text;?>" maxlength="128" /><br />
                        <span><em>Enter your navigation Next button text</em></span></td>
                </tr>
            </table>
        </div>

        <div class="stylesheet-table">

            <h4>2. Add Style to your Layout</h4>

            <table id="ftable" cellspacing="1">
                <tr><th colspan="2" class="aleft">Stylesheet</th></tr>
                <tr class="one-col two-col two-col-bot-slider"><td width="200">fixedly-cont</td><td><input type="text" name="style_fixedly_cont" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_cont) print $rows_affected_selected[0]->style_fixedly_cont;?>" maxlength="255" /></td></tr>
                <tr class="one-col two-col"><td>fixedly-inner-cont</td><td><input type="text" name="style_fixedly_inner_cont" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_inner_cont) print $rows_affected_selected[0]->style_fixedly_inner_cont;?>" maxlength="255" /></td></tr>
                <tr class="one-col two-col"><td>fixedly-inner</td><td><input type="text" name="style_fixedly_inner" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_inner) print $rows_affected_selected[0]->style_fixedly_inner;?>" maxlength="255" /></td></tr>
                <tr class="one-col two-col"><td>fixedly-inner img</td><td><input type="text" name="style_fixedly_inner_img" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_inner_img) print $rows_affected_selected[0]->style_fixedly_inner_img;?>" maxlength="255" /></td></tr>
                <tr class="one-col two-col two-col-bot-slider"><td>fixedly-inner-nav</td><td><input type="text" name="style_fixedly_inner_nav" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_inner_nav) print $rows_affected_selected[0]->style_fixedly_inner_nav;?>" maxlength="255" /></td></tr>
                <tr class="one-col two-col two-col-bot-slider"><td>fixedly-inner-nav-prev</td><td><input type="text" name="style_fixedly_inner_nav_prev" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_inner_nav_prev) print $rows_affected_selected[0]->style_fixedly_inner_nav_prev;?>" maxlength="255" /></td></tr>
                <tr class="one-col two-col two-col-bot-slider"><td>fixedly-inner-nav-next</td><td><input type="text" name="style_fixedly_inner_nav_next" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_inner_nav_next) print $rows_affected_selected[0]->style_fixedly_inner_nav_next;?>" maxlength="255" /></td></tr>
                <tr class="one-col two-col two-col-bot-slider"><td>fixedly-inner-head</td><td><input type="text" name="style_fixedly_inner_head" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_inner_head) print $rows_affected_selected[0]->style_fixedly_inner_head;?>" maxlength="255" /></td></tr>
                <tr class="one-col two-col two-col-bot-slider"><td>fixedly-inner-text</td><td><input type="text" name="style_fixedly_inner_text" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_inner_text) print $rows_affected_selected[0]->style_fixedly_inner_text;?>" maxlength="255" /></td></tr>
                <!-- two columns -->
                <tr class="two-col"><td>fixedly-inner-left</td><td><input type="text" name="style_fixedly_inner_left" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_inner_left) print $rows_affected_selected[0]->style_fixedly_inner_left;?>" maxlength="255" /></td></tr>
                <tr class="two-col"><td>fixedly-inner-right</td><td><input type="text" name="style_fixedly_inner_right" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_inner_right) print $rows_affected_selected[0]->style_fixedly_inner_right;?>" maxlength="255" /></td></tr>
                <!-- two columns with bottom slider -->
                <tr class="two-col-bot-slider"><td>fixedly-top-cont</td><td><input type="text" name="style_fixedly_top_cont" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_top_cont) print $rows_affected_selected[0]->style_fixedly_top_cont;?>" maxlength="255" /></td></tr>
                <tr class="two-col-bot-slider"><td>fixedly-top-left</td><td><input type="text" name="style_fixedly_top_left" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_top_left) print $rows_affected_selected[0]->style_fixedly_top_left;?>" maxlength="255" /></td></tr>
                <tr class="two-col-bot-slider"><td>fixedly-top-left select</td><td><input type="text" name="style_fixedly_top_left_select" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_top_left_select) print $rows_affected_selected[0]->style_fixedly_top_left_select;?>" maxlength="255" /></td></tr>
                <tr class="two-col-bot-slider"><td>fixedly-top-right</td><td><input type="text" name="style_fixedly_top_right" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_top_right) print $rows_affected_selected[0]->style_fixedly_top_right;?>" maxlength="255" /></td></tr>
                <tr class="two-col-bot-slider"><td>fixedly-top-right iframe</td><td><input type="text" name="style_fixedly_top_right_iframe" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_top_right_iframe) print $rows_affected_selected[0]->style_fixedly_top_right_iframe;?>" maxlength="255" /></td></tr>
                <tr class="two-col-bot-slider"><td>fixedly-bot-cont</td><td><input type="text" name="style_fixedly_bot_cont" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_bot_cont) print $rows_affected_selected[0]->style_fixedly_bot_cont;?>" maxlength="255" /></td></tr>
                <tr class="two-col-bot-slider"><td>fixedly-bot-slider</td><td><input type="text" name="style_fixedly_bot_slider" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_bot_slider) print $rows_affected_selected[0]->style_fixedly_bot_slider;?>" maxlength="255" /></td></tr>
                <tr class="two-col-bot-slider"><td>fixedly-bot-slider-cont</td><td><input type="text" name="style_fixedly_bot_slider_cont" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_bot_slider_cont) print $rows_affected_selected[0]->style_fixedly_bot_slider_cont;?>" maxlength="255" /></td></tr>
                <tr class="two-col-bot-slider"><td>fixedly-bot-slider-cont ul</td><td><input type="text" name="style_fixedly_bot_slider_cont_ul" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_bot_slider_cont_ul) print $rows_affected_selected[0]->    style_fixedly_bot_slider_cont_ul;?>" maxlength="255" /></td></tr>
                <tr class="two-col-bot-slider"><td>fixedly-bot-slider-cont ul li</td><td><input type="text" name="style_fixedly_bot_slider_cont_ul_li" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_bot_slider_cont_ul_li) print $rows_affected_selected[0]->style_fixedly_bot_slider_cont_ul_li;?>" maxlength="255" /></td></tr>
                <tr class="two-col-bot-slider"><td>fixedly-bot-slider-cont ul li img</td><td><input type="text" name="style_fixedly_bot_slider_cont_ul_li_img" class="ftxt" value="<?php if ($rows_affected_selected[0]->style_fixedly_bot_slider_cont_ul_li_img) print $rows_affected_selected[0]->style_fixedly_bot_slider_cont_ul_li_img;?>" maxlength="255" /></td></tr>
            </table>
        </div>

        <div class="scripts-table">

            <h4>3. Add Effects to your Layout</h4>

            <table id="ftable" cellspacing="1">
                <tr>
                    <th colspan="9" class="aleft"><input type="checkbox" name="" value="" checked disabled /> jQuery Cycle Effects  <a href="http://jquery.malsup.com/cycle/options.html" class="nodec"><sup>[jQuery Cycle Plugin Option Reference]</sup></a></th>
                </tr>
                <tr>
                    <td class="one-col two-col two-col-bot-slider">fx<br />
                        <select name="script_fx" class="required">
                            <option value="blindX"<?php if ($rows_affected_selected[0]->script_cycle_fx == "blindX") print "selected";?>>blindX</option>
                            <option value="blindY"<?php if ($rows_affected_selected[0]->script_cycle_fx == "blindY") print "selected";?>>blindY</option>
                            <option value="blindZ"<?php if ($rows_affected_selected[0]->script_cycle_fx == "blindZ") print "selected";?>>blindZ</option>
                            <option value="cover"<?php if ($rows_affected_selected[0]->script_cycle_fx == "cover") print "selected";?>>cover</option>
                            <option value="curtainX"<?php if ($rows_affected_selected[0]->script_cycle_fx == "curtainX") print "selected";?>>curtainX</option>
                            <option value="curtainY"<?php if ($rows_affected_selected[0]->script_cycle_fx == "curtainY") print "selected";?>>curtainY</option>
                            <option value="fade"<?php if ($rows_affected_selected[0]->script_cycle_fx == "fade") print "selected";?>>fade</option>
                            <option value="fadeZoom"<?php if ($rows_affected_selected[0]->script_cycle_fx == "fadeZoom") print "selected";?>>fadeZoom</option>
                            <option value="growX"<?php if ($rows_affected_selected[0]->script_cycle_fx == "growX") print "selected";?>>growX</option>
                            <option value="growY"<?php if ($rows_affected_selected[0]->script_cycle_fx == "growY") print "selected";?>>growY</option>
                            <option value="none"<?php if ($rows_affected_selected[0]->script_cycle_fx == "none") print "selected";?>>none</option>
                            <option value="scrollUp" <?php if ($rows_affected_selected[0]->script_cycle_fx == "scrollUp") print "selected";?>>scrollUp</option>
                            <option value="scrollDown" <?php if ($rows_affected_selected[0]->script_cycle_fx == "scrollDown") print "selected";?>>scrollDown</option>
                            <option value="scrollLeft" <?php if ($rows_affected_selected[0]->script_cycle_fx == "scrollLeft") print "selected";?>>scrollLeft</option>
                            <option value="scrollRight" <?php if ($rows_affected_selected[0]->script_cycle_fx == "scrollRight") print "selected";?>>scrollRight</option>
                            <option value="scrollHorz" <?php if ($rows_affected_selected[0]->script_cycle_fx == "scrollHorz") print "selected";?>>scrollHorz</option>
                            <option value="scrollVert" <?php if ($rows_affected_selected[0]->script_cycle_fx == "scrollVert") print "selected";?>>scrollVert</option>
                            <option value="shuffle" <?php if ($rows_affected_selected[0]->script_cycle_fx == "shuffle") print "selected";?>>shuffle</option>
                            <option value="slideX" <?php if ($rows_affected_selected[0]->script_cycle_fx == "slideX") print "selected";?>>slideX</option>
                            <option value="slideY" <?php if ($rows_affected_selected[0]->script_cycle_fx == "slideY") print "selected";?>>slideY</option>
                            <option value="toss" <?php if ($rows_affected_selected[0]->script_cycle_fx == "toss") print "selected";?>>toss</option>
                            <option value="turnUp" <?php if ($rows_affected_selected[0]->script_cycle_fx == "turnUp") print "selected";?>>turnUp</option>
                            <option value="turnDow" <?php if ($rows_affected_selected[0]->script_cycle_fx == "turnDown") print "selected";?>>turnDown</option>
                            <option value="turnLeft" <?php if ($rows_affected_selected[0]->script_cycle_fx == "turnLeft") print "selected";?>>turnLeft</option>
                            <option value="turnRight" <?php if ($rows_affected_selected[0]->script_cycle_fx == "turnRight") print "selected";?>>turnRight</option>
                            <option value="uncover" <?php if ($rows_affected_selected[0]->script_cycle_fx == "uncover") print "selected";?>>uncover</option>
                            <option value="wipe" <?php if ($rows_affected_selected[0]->script_cycle_fx == "wipe") print "selected";?>>wipe</option>
                            <option value="zoom" <?php if ($rows_affected_selected[0]->script_cycle_fx == "zoom") print "selected";?>>zoom</option>
                        </select><br />
                        <span><em>name of transition effect</em></span>
                    </td>
                    <td class="one-col two-col two-col-bot-slider">width<br /> <input type="text" name="script_width" class="ftxt" value="<?php if ($rows_affected_selected[0]->script_cycle_width) print $rows_affected_selected[0]->script_cycle_width;?>" maxlength="16" /><br />
                        <span><em>container width</em></span></td>
                    <td class="one-col two-col two-col-bot-slider">height<br /> <input type="text" name="script_height" class="ftxt" value="<?php if ($rows_affected_selected[0]->script_cycle_height) print $rows_affected_selected[0]->script_cycle_height;?>" maxlength="16" /><br />
                        <span><em>container height</em></span></td>
                    <td class="one-col two-col two-col-bot-slider">speed<br /> <input type="text" name="script_speed" class="ftxt" value="<?php if ($rows_affected_selected[0]->script_cycle_speed) print $rows_affected_selected[0]->script_cycle_speed;?>" maxlength="16" /><br />
                        <span><em>speed of the transition</em></span></td>
                    <td class="one-col two-col two-col-bot-slider">random<br /> <input type="text" name="script_random" class="ftxt" value="<?php if ($rows_affected_selected[0]->script_cycle_random) print $rows_affected_selected[0]->script_cycle_random;?>" maxlength="16" /><br />
                        <span><em></em>true for random, false for sequence</span></td>
                    <td class="one-col two-col two-col-bot-slider">pause<br /> <input type="text" name="script_pause" class="ftxt" value="<?php if ($rows_affected_selected[0]->script_cycle_pause) print $rows_affected_selected[0]->script_cycle_pause;?>" maxlength="16" /><br />
                        <span><em>true to enable "pause on hover"</em></span></td>
                    <td class="one-col two-col two-col-bot-slider">delay<br /> <input type="text" name="script_delay" class="ftxt" value="<?php if ($rows_affected_selected[0]->script_cycle_delay) print $rows_affected_selected[0]->script_cycle_delay;?>" maxlength="16" /><br />
                        <span><em>additional delay (in ms) for first transition</em></span></td>
                    <td class="one-col two-col two-col-bot-slider">continuous<br /> <input type="text" name="script_continuous" class="ftxt" value="<?php if ($rows_affected_selected[0]->script_cycle_continuous) print $rows_affected_selected[0]->script_cycle_continuous;?>" maxlength="16" /><br />
                        <span><em>true to start next transition immediately after current one completes</em></span></td>
                    <td class="one-col two-col two-col-bot-slider">timeout<br /> <input type="text" name="script_timeout" class="ftxt" value="<?php if ($rows_affected_selected[0]->script_cycle_timeout) print $rows_affected_selected[0]->script_cycle_timeout;?>" maxlength="16" /><br />
                        <span><em>milliseconds between slide transitions</em></span></td>
                </tr>
            </table>
        </div>

        <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Template') ?>" /></p>
    </form>
    <?php endif;?>
    
</div>

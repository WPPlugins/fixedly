<script type="text/javascript">
    jQuery(document).ready(function(){

        jQuery("select.handle").change(function () {

            jQuery(".media-table").hide();
            jQuery(".stylesheet-table").hide();
            jQuery(".scripts-table").hide();
            jQuery(".one-col").hide();
            jQuery(".two-col").hide();
            jQuery(".two-col-bot-slider").hide();

            jQuery("select.handle option:selected").each(function () {

                var layout = jQuery("select.handle option:selected").val();
                var template = jQuery("select.handle option:selected").text();

                if (layout != "") {

                    jQuery(".media-table").show();
                    jQuery(".stylesheet-table").show();
                    jQuery(".scripts-table").show();
                }

                if (layout == "one-column") {

                    jQuery(".one-col").show();
                }

                if (layout == "two-columns") {

                    jQuery(".two-col").show();
                }

                if (layout == "two-columns-with-bottom-slider") {

                    jQuery(".two-col-bot-slider").show();
                }
            });
        });
    });
</script>

<div class="fixedly-wrap">

    <h3>Fixedly / Create Templates</h3>

    <h4>1. Create New Template</h4>

    <?php if ($success != false) :?><p class="success"><strong><?php print $success;?></strong></p><?php endif;?>

    <form id="save-template" method="post" action="<?php print__FILE__;?>">
        <?php settings_fields('settings-group'); ?>
        <table id="ftable" cellspacing="1">
            <tr>
                <th>Template Name</th>
                <th class="aleft">Template Layout</th>
            </tr>
            <tr>
                <td>
                    <input type="text" name="title" value="" class="ftxt required" maxlength="64" /><br />
                    <span><em>You need to enter Title for your template (cannot exceed 64 characters).</em></span><br />
                </td>
                <td>
                    <select name="layout" class="layout required">
                        <option value="">-- choose one --</option>
                        <option value="one-column">one column</option>
                        <option value="two-columns">two columns</option>
                        <option value="two-columns-with-bottom-slider">two columns with bottom slider</option>
                    </select><br />
                    <span><em>You need to select Layout for your new template.</em></span>
                </td>
            </tr>
        </table>

        <br />

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
                    <td nowrap class="acenter"><input type="radio" name="show_title" value="show" checked /> <span>show</span><br />
                        <input type="radio" name="show_title" value="dont_show" /> <span>don't show</span></td>
                    <td nowrap class="acenter"><input type="radio" name="show_description" value="show" checked /> <span>show</span><br />
                        <input type="radio" name="show_description" value="dont_show" /> <span>don't show</span></td>
                    <td nowrap class="acenter"><input type="radio" name="show_nav" value="show" checked /> <span>show</span><br />
                        <input type="radio" name="show_nav" value="dont_show" /> <span>don't show</span></td>
                    <td class="one-col"><input type="text" name="tpl_col_width" class="ftxt" value="" maxlength="4" /><br />
                        <span><em>Enter the width of your column (px)</em></span></td>
                    <td class="two-col two-col-bot-slider"><input type="text" name="tpl_col_left_width" class="ftxt" value="" maxlength="4" /><br />
                        <span><em>Enter the width of your left column (px)</em></span></td>
                    <td class="two-col two-col-bot-slider"><input type="text" name="tpl_col_right_width" class="ftxt" value="" maxlength="4" /><br />
                        <span><em>Enter the width of your right column (px)</em></span></td>
                    <td class="one-col two-col two-col-bot-slider"><input type="text" name="tpl_col_height" class="ftxt" value="" maxlength="4" /><br />
                        <span><em>Enter the height of your template (px)</em></span></td>
                    <td class="two-col-bot-slider"><input type="text" name="tpl_screenshot_thumb_width" class="ftxt" value="<?php if ($rows_affected_selected[0]->screenshot_thumb_width) print $rows_affected_selected[0]->screenshot_thumb_width;?>" maxlength="4" /><br />
                        <span><em>Enter the width of your screenshot thumbnail.</em></span></td>
                    <td class="two-col-bot-slider"><input type="text" name="tpl_screenshot_thumb_height" class="ftxt" value="<?php if ($rows_affected_selected[0]->screenshot_thumb_height) print $rows_affected_selected[0]->screenshot_thumb_height;?>" maxlength="4" /><br />
                        <span><em>Enter the height of your screenshot thumbnail.</em></span></td>
                    <td class="one-col two-col two-col-bot-slider"><input type="text" name="tpl_nav_prev_text" class="ftxt" value="" maxlength="128" /><br />
                        <span><em>Enter your navigation Previous button text</em></span></td>
                    <td class="one-col two-col two-col-bot-slider"><input type="text" name="tpl_nav_next_text" class="ftxt" value="" maxlength="128" /><br />
                        <span><em>Enter your navigation Next button text</em></span></td>
                </tr>
            </table>
        </div>

        <div class="stylesheet-table">

            <h4>2. Add Style to your Layout</h4>

            <table id="ftable" cellspacing="1">
                <tr><th colspan="2" class="aleft">Stylesheet</th></tr>
                <tr class="one-col two-col two-col-bot-slider"><td width="200">fixedly-cont</td><td><input type="text" name="style_fixedly_cont" class="ftxt" value="" maxlength="255" /></td></tr>
                <tr class="one-col two-col"><td>fixedly-inner-cont</td><td><input type="text" name="style_fixedly_inner_cont" class="ftxt" value="" maxlength="255" /></td></tr>
                <tr class="one-col two-col"><td>fixedly-inner</td><td><input type="text" name="style_fixedly_inner" class="ftxt" value="" maxlength="255" /></td></tr>
                <tr class="one-col two-col"><td>fixedly-inner img</td><td><input type="text" name="style_fixedly_inner_img" class="ftxt" value="" maxlength="255" /></td></tr>
                <tr class="one-col two-col two-col-bot-slider"><td>fixedly-inner-nav</td><td><input type="text" name="style_fixedly_inner_nav" class="ftxt" value="" maxlength="255" /></td></tr>
                <tr class="one-col two-col two-col-bot-slider"><td>fixedly-inner-nav-prev</td><td><input type="text" name="style_fixedly_inner_nav_prev" class="ftxt" value="" maxlength="255" /></td></tr>
                <tr class="one-col two-col two-col-bot-slider"><td>fixedly-inner-nav-next</td><td><input type="text" name="style_fixedly_inner_nav_next" class="ftxt" value="" maxlength="255" /></td></tr>
                <tr class="one-col two-col two-col-bot-slider"><td>fixedly-inner-head</td><td><input type="text" name="style_fixedly_inner_head" class="ftxt" value="" maxlength="255" /></td></tr>
                <tr class="one-col two-col two-col-bot-slider"><td>fixedly-inner-text</td><td><input type="text" name="style_fixedly_inner_text" class="ftxt" value="" maxlength="255" /></td></tr>
                <!-- two columns -->
                <tr class="two-col"><td>fixedly-inner-left</td><td><input type="text" name="style_fixedly_inner_left" class="ftxt" value="" maxlength="255" /></td></tr>
                <tr class="two-col"><td>fixedly-inner-right</td><td><input type="text" name="style_fixedly_inner_right" class="ftxt" value="" maxlength="255" /></td></tr>
                <!-- two columns with bottom slider -->
                <tr class="two-col-bot-slider"><td>fixedly-top-cont</td><td><input type="text" name="style_fixedly_top_cont" class="ftxt" value="" maxlength="255" /></td></tr>
                <tr class="two-col-bot-slider"><td>fixedly-top-left</td><td><input type="text" name="style_fixedly_top_left" class="ftxt" value="" maxlength="255" /></td></tr>
                <tr class="two-col-bot-slider"><td>fixedly-top-left select</td><td><input type="text" name="style_fixedly_top_left_select" class="ftxt" value="" maxlength="255" /></td></tr>
                <tr class="two-col-bot-slider"><td>fixedly-top-right</td><td><input type="text" name="style_fixedly_top_right" class="ftxt" value="" maxlength="255" /></td></tr>
                <tr class="two-col-bot-slider"><td>fixedly-top-right iframe</td><td><input type="text" name="style_fixedly_top_right_iframe" class="ftxt" value="" maxlength="255" /></td></tr>
                <tr class="two-col-bot-slider"><td>fixedly-bot-cont</td><td><input type="text" name="style_fixedly_bot_cont" class="ftxt" value="" maxlength="255" /></td></tr>
                <tr class="two-col-bot-slider"><td>fixedly-bot-slider</td><td><input type="text" name="style_fixedly_bot_slider" class="ftxt" value="" maxlength="255" /></td></tr>
                <tr class="two-col-bot-slider"><td>fixedly-bot-slider-cont</td><td><input type="text" name="style_fixedly_bot_slider_cont" class="ftxt" value="" maxlength="255" /></td></tr>
                <tr class="two-col-bot-slider"><td>fixedly-bot-slider-cont ul</td><td><input type="text" name="style_fixedly_bot_slider_cont_ul" class="ftxt" value="" maxlength="255" /></td></tr>
                <tr class="two-col-bot-slider"><td>fixedly-bot-slider-cont ul li</td><td> <input type="text" name="style_fixedly_bot_slider_cont_ul_li" class="ftxt" value="" maxlength="255" /></td></tr>
                <tr class="two-col-bot-slider"><td>fixedly-bot-slider-cont ul li img</td><td><input type="text" name="style_fixedly_bot_slider_cont_ul_li_img" class="ftxt" value="" maxlength="255" /></td></tr>
            </table>


            <h4>3. Layout Grid</h4>

            <img src="<?php print FIXEDLY_PLUGIN_URL;?>images/one-column-layout-grid.jpg" alt="One Column Layout Grid" class="one-col" />
            <img src="<?php print FIXEDLY_PLUGIN_URL;?>images/two-columns-layout-grid.jpg" alt="One Column Layout Grid" class="two-col" />
            <img src="<?php print FIXEDLY_PLUGIN_URL;?>images/two-columns-with-bottom-slider-layout-grid.jpg" alt="One Column Layout Grid" class="two-col-bot-slider" />
        </div>

        <div class="scripts-table">

            <h4>4. Add Effects to your Layout</h4>

            <table id="ftable" cellspacing="1">
                <tr>
                    <th colspan="9" class="aleft"><input type="checkbox" name="" value="" checked disabled /> jQuery Cycle Effects  <a href="http://jquery.malsup.com/cycle/options.html" class="nodec"><sup>[jQuery Cycle Plugin Option Reference]</sup></a></th>
                </tr>
                <tr>
                    <td class="one-col two-col two-col-bot-slider">fx<br />
                        <select name="script_fx" class="required">
                            <option value="blindX">blindX</option>
                            <option value="blindY">blindY</option>
                            <option value="blindZ">blindZ</option>
                            <option value="cover">cover</option>
                            <option value="curtainX">curtainX</option>
                            <option value="curtainY">curtainY</option>
                            <option value="fade" selected>fade</option>
                            <option value="fadeZoom">fadeZoom</option>
                            <option value="growX">growX</option>
                            <option value="growY">growY</option>
                            <option value="none">none</option>
                            <option value="scrollUp">scrollUp</option>
                            <option value="scrollDown">scrollDown</option>
                            <option value="scrollLeft">scrollLeft</option>
                            <option value="scrollRight">scrollRight</option>
                            <option value="scrollHorz">scrollHorz</option>
                            <option value="scrollVert">scrollVert</option>
                            <option value="shuffle">shuffle</option>
                            <option value="slideX">slideX</option>
                            <option value="slideY">slideY</option>
                            <option value="toss">toss</option>
                            <option value="turnUp">turnUp</option>
                            <option value="turnDow">turnDown</option>
                            <option value="turnLeft">turnLeft</option>
                            <option value="turnRight">turnRight</option>
                            <option value="uncover">uncover</option>
                            <option value="wipe">wipe</option>
                            <option value="zoom">zoom</option>
                        </select><br />
                        <span><em>name of transition effect</em></span>
                    </td>
                    <td class="one-col two-col two-col-bot-slider">width<br /> <input type="text" name="script_width" class="ftxt" value="100%" maxlength="16" /><br />
                        <span><em>container width</em></span></td>
                    <td class="one-col two-col two-col-bot-slider">height<br /> <input type="text" name="script_height" class="ftxt" value="auto" maxlength="16" /><br />
                        <span><em>container height</em></span></td>
                    <td class="one-col two-col two-col-bot-slider">speed<br /> <input type="text" name="script_speed" class="ftxt" value="3000" maxlength="16" /><br />
                        <span><em>speed of the transition</em></span></td>
                    <td class="one-col two-col two-col-bot-slider">random<br /> <input type="text" name="script_random" class="ftxt" value="false" maxlength="16" /><br />
                        <span><em></em>true for random, false for sequence</span></td>
                    <td class="one-col two-col two-col-bot-slider">pause<br /> <input type="text" name="script_pause" class="ftxt" value="true" maxlength="16" /><br />
                        <span><em>true to enable "pause on hover"</em></span></td>
                    <td class="one-col two-col two-col-bot-slider">delay<br /> <input type="text" name="script_delay" class="ftxt" value="1000" maxlength="16" /><br />
                        <span><em>additional delay (in ms) for first transition</em></span></td>
                    <td class="one-col two-col two-col-bot-slider">continuous<br /> <input type="text" name="script_continuous" class="ftxt" value="true" maxlength="16" /><br />
                        <span><em>true to start next transition immediately after current one completes</em></span></td>
                    <td class="one-col two-col two-col-bot-slider">timeout<br /> <input type="text" name="script_timeout" class="ftxt" value="1000" maxlength="16" /><br />
                        <span><em>milliseconds between slide transitions</em></span></td>
                </tr>
            </table>
        </div>

        <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Template') ?>" /></p>
    </form>

</div>





    jQuery(document).ready(function(){
    
        jQuery("select.layout").change(function () {

            jQuery(".media-table").hide();
            jQuery(".stylesheet-table").hide();
            jQuery(".scripts-table").hide();
            jQuery(".one-col").hide();
            jQuery(".two-col").hide();
            jQuery(".two-col-bot-slider").hide();
            
            jQuery(".media-table .one-col input, .media-table .two-col input, .media-table .two-col-bot-slider input").val('');
            jQuery(".stylesheet-table .one-col input, .stylesheet-table .two-col input, .stylesheet-table .two-col-bot-slider input").val('');

            jQuery("select.layout option:selected").each(function () {
            
                var layout = jQuery("select.layout option:selected").val();

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

        var orig_send_to_editor = window.send_to_editor;

        jQuery('.fixedly_upload_image_button').click(function() {
        
            formfield = jQuery(this).prev('input');
            tb_show('Fixedly Media Gallery', 'media-upload.php?type=image&TB_iframe=true&&tab=library&width=640&height=640');

            window.send_to_editor = function(html) {
            
                var regex = /src="(.+?)"/;
                var rslt =html.match(regex);
                var imgurl = rslt[1];
                formfield.val(imgurl);
                tb_remove();
                
                jQuery('#show_'+formfield.attr('name')).html('<img src="'+imgurl+'" width="150" />')
                    window.send_to_editor = orig_send_to_editor;
            }

            return false;
        });
        
        jQuery("#add-new-gallery").validate();
        jQuery("#add-new-images").validate();
        jQuery("#add-new-videos").validate();
        jQuery("#add-new-slides").validate();
        jQuery("#save-template").validate();
        
        jQuery('.fixedly_edit').editable('admin.php?page=fixedly/fixedly.php&do=save_title', {
            submit    : 'Save',
            indicator : 'Saving...',
            tooltip   : 'Click to edit media title...'
        });
        
        jQuery('.fixedly_edit_area').editable('admin.php?page=fixedly/fixedly.php&do=save_desc', {
            type      : 'textarea',
            submit    : 'Save',
            indicator : 'Saving...',
            tooltip   : 'Click to edit media description...'
        });
        
        jQuery('.fixedly_slide_link').editable('admin.php?page=fixedly/fixedly.php&do=save_link', {
            submit    : 'Save',
            indicator : 'Saving...',
            tooltip   : 'Click to edit media link...'
        });
        
        jQuery('.fixedly_edit_tmpl').editable('admin.php?page=fixedly/fixedly.php&do=save_tmpl', {
            loadurl   : "admin.php?page=fixedly/fixedly.php&do=load_tmpl",
            type      : 'select',
            submit    : 'Save',
            indicator : 'Saving...',
            tooltip   : 'Click to edit gallery template...'
        });
        
        jQuery('.fixedly_edit_type').editable('admin.php?page=fixedly/fixedly.php&do=save_type', {
            data      : "{'image':'image','video':'video','slideshow':'slideshow'}",
            type      : 'select',
            submit    : 'Save',
            indicator : 'Saving...',
            tooltip   : 'Click to edit gallery type...'
        });
        
        jQuery('.add-more-rows').click(function() {
        
            jQuery('.hidden-row').show();
        });
    });
    
    function addNewVideoRow() {

        var table = document.getElementById("ftable");

        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount);

        var radioCnt = rowCount - 1;

        var cell1 = row.insertCell(0);
        
        var element1 = document.createElement("input");
        element1.type = "text";
        element1.name = "title[]";
        element1.className = "ftxt required";
        element1.maxLength = "255";
        element1.value = "";
        cell1.appendChild(element1);

        var cell2 = row.insertCell(1);
        
        var element2 = document.createElement("textarea");
        element2.name = "description[]";
        element2.className = "fta required";
        cell2.appendChild(element2);

        var cell3 = row.insertCell(2);
        
        var element5 = document.createElement("input");
        element5.type = "radio";
        element5.name = "type[" + radioCnt + "]";
        element5.value = "youtube";
        cell3.appendChild(element5);
        
        var element6 = document.createElement("span");
        element6.innerHTML = " YouTube &nbsp; ";
        cell3.appendChild(element6);
        
        var element7 = document.createElement("input");
        element7.type = "radio";
        element7.name = "type[" + radioCnt + "]";
        element7.value = "vimeo";
        cell3.appendChild(element7);

        var element8 = document.createElement("span");
        element8.innerHTML = " Vimeo &nbsp; ";
        cell3.appendChild(element8);
        
        var element9 = document.createElement("input");
        element9.type = "radio";
        element9.name = "type[" + radioCnt + "]";
        element9.value = "dailymotion";
        cell3.appendChild(element9);

        var element10 = document.createElement("span");
        element10.innerHTML = " Dailymotion &nbsp; ";
        cell3.appendChild(element10);
        
        var element4 = document.createElement("p");
        cell3.appendChild(element4);
        
        var element3 = document.createElement("input");
        element3.type = "text";
        element3.name = "link[]";
        element3.className = "ftxt required";
        element3.maxLength = "255";
        element3.value = "";
        cell3.appendChild(element3);
    }

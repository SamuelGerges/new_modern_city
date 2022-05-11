

function images_preview(input_file_id, input_file_name, holder_img_id, func_style_img, func_style_input_text, type_file = null, object_name_has_slider = null) {

    // holder_img_id ==> div will hold img
    // type_file ( slider or image )
    // func_style_img ==> css func name for image or slider
    // func_style_input_text=> col-md-3 pr-md-1 or col-md-6 pr-md-1


    $("#"+input_file_id).on('change', function () {

        console.log(input_file_id, input_file_name, holder_img_id);
        if (this.files) {
            let count_of_files = this.files.length;
            let img_holder = $("#"+holder_img_id);
            let count_current_files;



            let div = 'col-md-6 pr-md-1';

            if(type_file === 'slider'){
                count_current_files = parseInt('<?= count($'+ object_name_has_slider + '->' + input_file_name+ '?>');  //count slider images
                count_of_files = count_of_files + count_current_files;
            }
            else {
                count_current_files = 0;
            }

            for( let i = count_current_files ; i < count_of_files; i++) {
                let reader = new FileReader();
                reader.onload = function () {
                    let image = $("<img />", {
                        "src": this.result,
                        "class": func_style_img ,
                    });
                    if( type_file === 'slider'){
                        let imgd_div = $('<div>',{
                            class: func_style_input_text,
                        });
                        image.appendTo(imgd_div);
                        image.appendTo(img_holder);

                        /******* generate Title && Alt inputs ********/

                        let label_title = $("<label>", {
                            "text": 'Title',
                        });

                        let input_title = $("<input>", {
                            "type": 'text',
                            "placeholder": "Image Title",
                            "name": `${input_file_name}[${i}][title]`,
                            "class": "form-control"
                        });

                        let title = $('<div >',{
                            class: func_style_input_text,
                        });
                        label_title.appendTo(title);
                        input_title.appendTo(title);
                        title.appendTo(img_holder);

                        let label_alt = $("<label>", {
                            "text": 'Alt',
                        });
                        let input_alt = $("<input>", {
                            "type": 'text',
                            "placeholder": "Image Alt",
                            "name": `${input_file_name}[${i}][alt]`,
                            "class": "form-control"
                        });
                        let alt = $('<div >',{
                            class: func_style_input_text,
                        });
                        label_alt.appendTo(alt);
                        input_alt.appendTo(alt);
                        alt.appendTo(img_holder);

                    }
                    else{
                        image.appendTo(img_holder);
                    }

                };
                img_holder.show();
                reader.readAsDataURL(this.files[i - count_current_files]);
            }
        }
        else {
            alert("This browser does not support FileReader.");
        }
    });
}









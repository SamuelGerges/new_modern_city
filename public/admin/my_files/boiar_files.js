


function image_preview(input_file_id, input_file_name, holder_img_id, func_style_img_name, input_text_style_name, type_file = null, object_has_slider_name = null) {
    // div will hold img
    // type_file ( slider or image )
    // func_style_img_name ==> css func name for image or slider
    // input_text_style_name => col-md-3 pr-md-1 or col-md-6 pr-md-1



    $(input_file_id).on('change', function () {

        alert(input_file_id + input_file_name);
        if (this.files) {
            let count_all_files = this.files.length;
            let img_holder = $(holder_img_id);
            let count_current_files;

            let div = 'col-md-6 pr-md-1';

            if(type_file === 'slider'){
                count_current_files = parseInt('<?= count($'+ object_has_slider_name + '->' + input_file_name+ '?>');  //count slider images
                count_all_files = count_all_files + count_current_files;
            }
            else {
                count_current_files = 0;
            }

            for( let i = count_current_files ; i < count_all_files; i++) {
                let reader = new FileReader();
                reader.onload = function () {
                    let image = $("<img />", {
                        "src": this.result,
                        "class": func_style_img_name ,
                    });
                    if( type_file === 'slider'){
                        let imgd_div = $('<div>',{
                            class: input_text_style_name,
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
                            class: input_text_style_name,
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
                            class: input_text_style_name,
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


function avatar_img_preview(input_file_id, img_holder_id, img_style_func_name, img_id) {




    $(input_file_id).on('change', function () {
        if (this.files) {
            let image_holder = $(img_holder_id);
            let image_id = $('#'+img_id);

            console.log(image_id);
            console.log(input_file_id);

            let reader = new FileReader();


            reader.onload = function () {
                $(image_id).remove();
                $("<img />", {
                    "src": this.result,
                    "class": img_style_func_name,
                    "id": img_id
                }).appendTo(image_holder);
            };
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[0]);

        }
        else {
            alert("This browser does not support FileReader.");
        }
    });

}




<?php




    function single_img_upload($data, $img_index_name, $img_alt, $upload_dir_name){
        // $upload_dir_name ==> ex => uploads/user

        if(isset($data[$img_index_name]['url'])){

            $hashed_img_name = $data[$img_index_name]['url']->hashName();

            Image::make($data[$img_index_name]['url'])->resize(200,200)->save(public_path($upload_dir_name.'/'.$hashed_img_name ));

            $data[$img_index_name]['url'] = $hashed_img_name ;
            $data[$img_index_name]['alt'] = $img_alt ;

            $data[$img_index_name] = json_encode($data[$img_index_name]);

            return $data[$img_index_name];
        }


    }
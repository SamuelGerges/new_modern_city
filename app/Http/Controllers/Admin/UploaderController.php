<?php
/**
 * Created by PhpStorm.
 * User: boiar
 * Date: 15/04/22
 * Time: 06:47 م
 */

namespace App\Http\Controllers\Admin;
use Faker\Provider\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

trait UploaderController
{


    function single_img_upload($data, $img_index_name, $img_alt, $upload_dir_name, $old_img_name = null){
        // $upload_dir_name ==> ex => users || places




        if(isset($data[$img_index_name]['url'])){

            if($old_img_name != null && Storage::disk('uploads')->exists($upload_dir_name.'/'. $old_img_name)){

                Storage::disk('uploads')->delete($upload_dir_name.'/'. $old_img_name);
            }


            $hashed_img_name = $data[$img_index_name]['url']->hashName();

            Image::make($data[$img_index_name]['url'])->resize(200,200)->save(public_path('uploads/'. $upload_dir_name.'/'.$hashed_img_name ));

            $data[$img_index_name]['url'] = $hashed_img_name ;
            $data[$img_index_name]['alt'] = $img_alt ;



            $data[$img_index_name] = json_encode($data[$img_index_name]);
           return $data;

        }
        else {
            return $data;
        }


    }
}
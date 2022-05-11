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

    function single_img_upload($data, $img_index_name, $upload_dir_name, $old_img_name =null, $alt = null)
    {
        // $upload_dir_name ==> ex => users || places

        $alt != null ? $data[$img_index_name]['alt'] = $alt : null;

        if(isset($data[$img_index_name]['url'])){
            if($old_img_name != null && Storage::disk('uploads')->exists($upload_dir_name.'/'. $old_img_name)){
                Storage::disk('uploads')->delete($upload_dir_name.'/'. $old_img_name);
            }

            $hashed_img_name = $data[$img_index_name]['url']->hashName();
            Image::make($data[$img_index_name]['url'])->resize(200,200)->save(public_path('uploads/'. $upload_dir_name.'/'.$hashed_img_name ));
            $data[$img_index_name]['url']   = $hashed_img_name;
            $data[$img_index_name] = json_encode($data[$img_index_name]);


        }
        else {

            if($old_img_name == null){
                unset($data[$img_index_name]);
            }
            else{
                $data[$img_index_name]['url']   = $old_img_name;
                $data[$img_index_name] = json_encode($data[$img_index_name]);
            }
        }

        return $data;

    }

    public function slider_img_upload($data, $slider_index_name, $upload_dir_name)
    {
        // $upload_dir_name ==> ex => users || places

        /**************  delete old slider images ***************/
        if(isset($data['slider_img']['deleted_urls'])){
            $deleted_urls = $data['slider_img']['deleted_urls'];
            for($i  = 0; $i < count($deleted_urls); $i++){
                if(isset($deleted_urls[$i]) && Storage::disk('uploads')->exists($upload_dir_name.'/'. $deleted_urls[$i])){
                    print_r($deleted_urls[$i]);
                    Storage::disk('uploads')->delete($upload_dir_name.'/'. $deleted_urls[$i]);
                }
            }
            unset($data['slider_img']['deleted_urls']);
        }


        $old_urls   = isset($data['slider_img']['url']['old']) ?  $data['slider_img']['url']['old'] : array();
        $new_urls   = isset($data['slider_img']['url']['new']) ?  $data['slider_img']['url']['new'] : array();
        $all_urls   = array_merge($old_urls, $new_urls);

        if(!empty($all_urls)){
            $all_titles = isset($data[$slider_index_name]['title'])? array_merge($data[$slider_index_name]['title']) : '';
            $all_alts   = isset($data[$slider_index_name]['alt'])? array_merge($data[$slider_index_name]['alt']) : '';
            $slider_data = array();

            for($i = 0; $i < count($all_urls); $i++){
                if(!Storage::disk('uploads')->exists($upload_dir_name.'/'. $all_urls[$i]) && file_exists($all_urls[$i])){
                    $hashed_img_name = $all_urls[$i]->hashName();
                    Image::make($all_urls[$i])->resize(200,200)->save(public_path('uploads/'. $upload_dir_name.'/'.$hashed_img_name));
                }
                else{
                    $hashed_img_name  = $all_urls[$i];
                }
                $slider_data[$i]['url']    = $hashed_img_name;
                $slider_data[$i]['alt']    = $all_alts[$i];
                $slider_data[$i]['title']  = $all_titles[$i];
            }
            $data[$slider_index_name] = json_encode($slider_data);
        }
        else{
            $data['slider_img'] = null;
        }

        return $data;
    }
}
function single_img_upload_api($data, $img_index_name, $upload_dir_name, $old_img_name =null, $alt = null)
{
    // $upload_dir_name ==> ex => users || places

    $alt != null ? $data[$img_index_name]['alt'] = $alt : null;

    if(isset($data[$img_index_name])){
        if($old_img_name != null && Storage::disk('uploads')->exists($upload_dir_name.'/'. $old_img_name)){
            Storage::disk('uploads')->delete($upload_dir_name.'/'. $old_img_name);
        }

        $hashed_img_name = $data[$img_index_name]->hashName();
        Image::make($data[$img_index_name])->resize(200,200)->save(public_path('uploads/'. $upload_dir_name.'/'.$hashed_img_name ));
        $data[$img_index_name]['url']   = $hashed_img_name;
        $data[$img_index_name] = json_encode($data[$img_index_name]);
    }
    else {
        if($old_img_name == null){
            unset($data[$img_index_name]);
        }
        else{
            $data[$img_index_name]['url']   = $old_img_name;
            $data[$img_index_name] = json_encode($data[$img_index_name]);
        }
    }

    return $data;

}


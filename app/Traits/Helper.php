<?php 
namespace App\Traits;

use Illuminate\Support\Facades\Request;

trait Helper
{
    public function responseJson($msg,$data=[],$status=200){
        $res=[
            'message' => $msg,
            'data' => $data,
            'status' => $status
        ];
        return response()->json($res,$status);
    }

    public function uploadImage($image,$folder='uploads'){
    
        // $path=$module->$image;

        // if($path!=null && file_exists(public_path($path))){

        //     unlink(public_path($path));
        // }
        
        // $folder="uploads/products/images";
        $img_name = random_int(11111,99999).random_int(11111111,99999999).".".$image->getClientOriginalExtension();
        $image->move(public_path($folder), $img_name);
        $img_path = $folder.'/'.$img_name;

        return $img_path;
    }
}
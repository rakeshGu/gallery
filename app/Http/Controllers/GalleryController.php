<?php
namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;     

class GalleryController extends Controller
{
    public function viewImage(){
        $gallery = Gallery::orderBy('id', 'DESC')->paginate(5);
        $count = 1;
        if(isset($_GET['page']) && $_GET['page']>1) $count = (($_GET['page']-1)*2)+1;
        return view('view_image', ["images"=>$gallery, 'counter'=>$count]);
    }


    public function addImage(){ 
        return view('add_image');
    }

    
    public function mapView(Request $request){
        $gallery = Gallery::find($request->id);
        $imgLat =  '30.894901';
        $imgLng =  '75.891602';
        if(isset($gallery->imgLat) && $gallery->imgLat !=''){
            $imgLat =  $gallery->imgLat;
        }
        if(isset($gallery->imgLng) && $gallery->imgLng !=''){
            $imgLng =  $gallery->imgLng;
        } 
        return view('map_view', ["imgLat"=>$imgLat, 'imgLng'=>$imgLng]);
    }
    
    public function storeImage(Request $request){
        $this->validate($request,[
            'user_name'=>'required',
            'image'=>'required|image|mimes:jpeg,png,jpg|max:5000'
        ]);        

        $user_name = $request->input('user_name');
        $image = $request->file('image');
        $extension = $image->getClientOriginalExtension();//Getting extension
        $originalname = $image->getClientOriginalName();//Getting original name
        $mimetype = $image->getClientMimeType();//Get MIME type
        $path = $image->move(public_path('image'), $originalname);//This will store in customize folder
        $imgsizes = $path->getSize();
        $data = getimagesize($path);
        $width = $data[0]; 
        $height = $data[1];
        $storedPath =  'image/'.$originalname; 
        $now = time();

        //latitude & longitude
        $imgLat = $request->input('lat');
        $imgLng = $request->input('lon');

        if($extension == 'jpg'){
            //get location of image 
            $imgLocation = $this->get_image_location($path);
            if(isset($imgLocation['latitude']) && $imgLocation['latitude'] !=""){
                $imgLat = $imgLocation['latitude'];
            }
            if(isset($imgLocation['longitude']) && $imgLocation['longitude'] !=""){
                $imgLng = $imgLocation['longitude'];
            }
        }
         
        //Start Store in Database
        $picture = new Gallery();  
        $picture->image = $originalname;
        $picture->height = $height;
        $picture->width = $width;
        $picture->size = $imgsizes;
        $picture->extension = $extension;
        $picture->user_name = $user_name;
        $picture->image_path = $storedPath;     
        $picture->imgLat = $imgLat;     
        $picture->imgLng = $imgLng;     
        $picture->created_at = $now;     
        $picture->save();  

        return redirect()->route('images.view');
    }
    
    public function get_image_location($image = ''){
        $exif = exif_read_data($image, 0, true);
        if($exif && isset($exif['GPS'])){ 
            if(isset($exif['GPS']['GPSLatitudeRef']) && isset($exif['GPS']['GPSLatitude']) && isset($exif['GPS']['GPSLongitudeRef']) && isset($exif['GPS']['GPSLongitude'])){
                $GPSLatitudeRef = $exif['GPS']['GPSLatitudeRef'];
                $GPSLatitude    = $exif['GPS']['GPSLatitude'];
                $GPSLongitudeRef= $exif['GPS']['GPSLongitudeRef'];
                $GPSLongitude   = $exif['GPS']['GPSLongitude'];
                
                $lat_degrees = count($GPSLatitude) > 0 ? $this->gps2Num($GPSLatitude[0]) : 0;
                $lat_minutes = count($GPSLatitude) > 1 ? $this->gps2Num($GPSLatitude[1]) : 0;
                $lat_seconds = count($GPSLatitude) > 2 ? $this->gps2Num($GPSLatitude[2]) : 0;
                
                $lon_degrees = count($GPSLongitude) > 0 ? $this->gps2Num($GPSLongitude[0]) : 0;
                $lon_minutes = count($GPSLongitude) > 1 ? $this->gps2Num($GPSLongitude[1]) : 0;
                $lon_seconds = count($GPSLongitude) > 2 ? $this->gps2Num($GPSLongitude[2]) : 0;
                
                $lat_direction = ($GPSLatitudeRef == 'W' or $GPSLatitudeRef == 'S') ? -1 : 1;
                $lon_direction = ($GPSLongitudeRef == 'W' or $GPSLongitudeRef == 'S') ? -1 : 1;
                
                $latitude = $lat_direction * ($lat_degrees + ($lat_minutes / 60) + ($lat_seconds / (60*60)));
                $longitude = $lon_direction * ($lon_degrees + ($lon_minutes / 60) + ($lon_seconds / (60*60)));
        
                return array('latitude'=>$latitude, 'longitude'=>$longitude);
            } else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function gps2Num($coordPart){
        $parts = explode('/', $coordPart);
        if(count($parts) <= 0)
        return 0;
        if(count($parts) == 1)
        return $parts[0];
        return floatval($parts[0]) / floatval($parts[1]);
    }    
}

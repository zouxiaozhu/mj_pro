<?php
namespace Zfile;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
class ZMediaService {
    protected  $ffmpeg;
    public function __construct()
    {
        $this->ffmpeg = FFMpeg::create(array(
            'ffmpeg.binaries'  => '/usr/local/bin/ffmpeg',
            'ffprobe.binaries' => '/usr/local/bin/ffprobe',
            'timeout'          => 3600, // The timeout for the underlying process
            'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
        ));
    }
    
    public function getVideoPicture(){
        $video= $this->ffmpeg->open('/Users/jiuji/Desktop/ceshi.mp4')->getFormat();
        $ffm  = $video->frame(TimeCode::fromSeconds(2));
        $file_name = uniqid(str_random(5));
        $file_type = 'png';
        $ffm->save($file_name.$file_type);
    }
    
    public function getVideoSplit(){
        
 
        
//        $video = $this->ffmpeg->open('/Users/jiuji/Desktop/ceshi.mp4');
//        $ret = $video->filters()->clip(TimeCode::fromSeconds(8),TimeCode::fromSeconds(10))->synchronize()->resample(1);
//        var_dump(get_class_methods($ret));die;
    }
    
}
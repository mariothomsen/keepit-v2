<?php
namespace App\Utils;
define('UPLOAD_DIR', 'uploads/');

class LocalFiles
{
    public function save(string $data): string
    {

        


        function make_thumb($src, $dest, $desired_width, $type) {
            //$exif = exif_read_data($src);
            //var_dump($exif);
            
            if($type === 'jpg' || $type === 'jpeg'){
                $source_image = imagecreatefromjpeg($src);
            }
            if($type === 'png'){
                $source_image = imagecreatefrompng($src);
            }
            if($type === 'gif'){
                $source_image = imagecreatefromgif($src);
            }
            $width = imagesx($source_image);
            $height = imagesy($source_image);
            $desired_height = floor($height * ($desired_width / $width));
            $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
            imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
            imagejpeg($virtual_image, $dest);           
        }


        if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif
            if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
                throw new \Exception('invalid image type');
            }
            $data = str_replace( ' ', '+', $data );
            if ($data === false) {
                throw new \Exception('base64_decode failed');
            } else {
                $data = base64_decode($data);
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }

        $uuid = uniqid();
        $file = UPLOAD_DIR . $uuid . '.' . $type;
        file_put_contents($file , $data);
        $thumbFile = UPLOAD_DIR . $uuid . '-thumb.' . $type;
        $desired_width="500";
        make_thumb($file, $thumbFile, $desired_width, $type);
        /************************************* */
        function correctImageOrientation($filename)
        {
            $exif = exif_read_data($filename);
            if ($exif && isset($exif['Orientation'])) {
                $orientation = $exif['Orientation'];
                if ($orientation != 1) {
                    $img = imagecreatefromjpeg($filename);
                    $deg = 0;
                    switch ($orientation) {
                        case 3:
                            $deg = 180;
                            break;
                        case 6:
                            $deg = 270;
                            break;
                        case 8:
                            $deg = 90;
                            break;
                    }
                    if ($deg) {
                        $img = imagerotate($img, $deg, 0);
                    }
                    imagejpeg($img, $filename, 95);
                }
            }
        }

        correctImageOrientation($thumbFile);

        return $file;

        /************************************ */
    }

    public function delete(string $data): void
    {
        unlink($data);
    }
}


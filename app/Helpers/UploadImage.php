<?php

namespace Shareexo\Helpers;

class UploadImage {

    public function moveUploadedFile($uploaded, $directory = "uploads/images/"){
        if(!is_dir($directory)){
            mkdir($directory, 0777, true);    
        }

        $extension = pathinfo($uploaded->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploaded->moveTo($directory . $filename, );

        return $filename;
    }

}
<?php

namespace Shareexo\Helpers;

class Hash{

    public function slug(){
        return bin2hex(random_bytes(32));
    }

}
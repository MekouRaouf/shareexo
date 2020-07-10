<?php

namespace Shareexo\Helpers;

use Psr\Http\Message\ServerRequestInterface;

class GetQuestionSlug{

    public function getslug(ServerRequestInterface $request){
        $uri = $request->getUri();
        $uri_pieces = explode('/', $uri);
        $count = count($uri_pieces);
        $count = (int) $count - 1;

        return $uri_pieces[$count];
    }

}
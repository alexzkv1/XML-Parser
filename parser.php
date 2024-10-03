<?php

function split($doc){
    $result = [];
    $currentToken = '';
    $insideTag = false;

    for( $i = 0; $i < strlen($doc); $i++ ){
        $char = $doc[$i];

        if($char === '<'){
            if($currentToken !==''){
                $result[] = $currentToken;
                $currentToken = '';
        }
        $insideTag = true;
        $currentToken = '<';
        }
        elseif($char === '>'){
            $currentToken .= '>';
            $result[] = $currentToken;
            $currentToken = '';
            $insideTag = false;
        }
        else{
            $currentToken .= $char;
        }   

    }
    if($currentToken !== ''){
        $result[] = $currentToken;
    }

    return $result;
}


function Tag($char){
    return strlen($char) > 1 && $char[0] === '<' && $char[strlen($char) - 1] === '>';
}

function closingTag($char){
    return strlen($char) > 2 && $char[1] === '/';
}

?>;
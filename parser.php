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

?>;
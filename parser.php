<?php

echo 'Select a mode => 1 - File; 2 - Input: ';

$handle = fopen('php://stdin', 'r');
$input = trim(fgets($handle));


if ($input == "1") {
    echo 'Enter path to your file here =>: ';
    $filePath = trim(fgets($handle));
    $file = trim(file_get_contents($filePath));
    $result = formater($file);
    echo $result;
} elseif ($input == "2") {
    echo 'Enter unformated XML here =>: ';
    $unformatedXml = trim(fgets($handle));
    echo 'Formated XML:' . "\n" . formater($unformatedXml);
} else {
    echo 'Invalid number';
};

function split($doc){
    $result = [];
    $currentToken = '';

    for( $i = 0; $i < strlen($doc); $i++ ){
        $char = $doc[$i];

        if($char === '<'){
            if($currentToken !==''){
                $result[] = $currentToken;
                $currentToken = '';
        }

        $currentToken = '<';
        }
        elseif($char === '>'){
            $currentToken .= '>';
            $result[] = $currentToken;
            $currentToken = '';

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


function formater($doc){
$chars = split($doc);
$output = '';
$spaceLevel = 0;
$openingTag = false;
$makeSpace = false;

foreach( $chars as $char ){
    $char = trim($char);

    if(Tag($char)){
        if(closingTag($char)){
            $spaceLevel--;
            if ($makeSpace) {
                $output .= $char . "\n";
                $makeSpace = false;
            } else {
                $output .= str_repeat('  ', $spaceLevel) . $char . "\n";
            }
            $openingTag = false;
        } 
        else{
        $output .= str_repeat('  ', $spaceLevel) . $char . "\n";
        $spaceLevel++;
        $openingTag = true;
        }   
    } 
    else{
        if($openingTag){
            $output = rtrim($output, "\n");
            $output .= $char;
            $openingTag = false;
            $makeSpace = true;
        } 
        else{
            $output .= str_repeat('  ', $spaceLevel) . $char . "\n";
        }
    }
        
}

return $output;
}

?>
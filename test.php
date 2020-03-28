<?php
/**
 * Created by PhpStorm.
 * User: hocvt
 * Date: 2020-03-27
 * Time: 15:37
 */

ini_set( 'display_errors', 1 );
error_reporting( E_ALL );

require __DIR__ . "/vendor/autoload.php";

$file = __DIR__ . "/vn.001.pdf";

$converter = new HocVT\PdfToText\Converter();

$page = 5;

$text = $converter->run( $file, $page );

$lines = explode( "\n", $text );

$last_line = '';

$result = "";

$joiner = new \HocVT\PdfToText\Joiner();

foreach ( $lines as $line ) {
    if ( $last_line && $line ) {
        $words1 = explode( " ", $last_line );
        $words2 = explode( " ", $line );
        
        if ( count( $words1 ) < 3 ) {
            $string1 = $last_line;
        } else {
            $string1 = implode( " ", array_slice( $words1, - 2 ) );
        }
        if ( count( $words2 ) < 3 ) {
            $string2 = $line;
        } else {
            $string2 = implode( " ", array_slice( $words2, 0, 2 ) );
        }
        $result .= ( $joiner->shouldJoin( $string1, $string2 ) ? " " : "\n" ) . $line;
    } else {
        $result .= " \n" . $line;
    }
    $last_line = $line;
}

dump( $text, "===============", $result );

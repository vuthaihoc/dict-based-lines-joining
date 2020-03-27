<?php
/**
 * Created by PhpStorm.
 * User: hocvt
 * Date: 2020-03-27
 * Time: 15:37
 */

require __DIR__ . "/vendor/autoload.php";

$file = __DIR__ . "/vn.001.pdf";

$converter = new HocVT\PdfToText\Converter();

$text = $converter->run( $file );

echo $text;
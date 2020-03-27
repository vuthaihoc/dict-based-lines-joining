<?php
/**
 * Created by PhpStorm.
 * User: hocvt
 * Date: 2020-03-27
 * Time: 16:12
 */

namespace HocVT\PdfToText;


use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class Joiner {
    
    protected $wiki_api = "https://vi.wikipedia.org/w/index.php?sort=relevance&search=%22__query__%22&ns0=1";
    
    public function shouldJoin($string1, $string2) : bool {
        /**
         * Ý tưởng: Sử dụng wikipedia search chính xác cụm từ nói string1 và string2,
         * nếu xuất hiện chuỗi chính xác trong kết quả tìm kiếm thì trả về true
         */
        return true;
    }
    
    protected function getHtml($query){
        $url = str_replace( "__query__", urlencode( $query ), $this->wiki_api );
        $response = (new Client())->get($url);
    }
    
}
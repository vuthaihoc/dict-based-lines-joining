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
    
    /**
     * Ý tưởng: Sử dụng wikipedia search chính xác cụm từ nói string1 và string2,
     * nếu xuất hiện chuỗi chính xác trong kết quả tìm kiếm thì trả về true
     */
    public function shouldJoin($string1, $string2) : bool {
        try{
            $query = $string1 . " " . $string2;
            $query = trim( $query, ".-:;,");
            $crawler = $this->getHtml( $string1 . " " . $string2 );
            $results = $crawler->filter( "ul.mw-search-results li div.searchresult");
            /** @var \DOMElement $result */
            foreach ($results as $result){
                if(strpos( $result->textContent, $query ) !== false){
                    return true;
                }
            }
        }catch (\Exception $ex){
            
        }
        
        return false;
    }
    
    protected function getHtml($query){
        $url = str_replace( "__query__", urlencode( $query ), $this->wiki_api );
        $response = (new Client())->get($url);
        $html = $response->getBody()->getContents();
        $crawler = new Crawler();
        $crawler->addHtmlContent( $html );
        return $crawler;
    }
    
}
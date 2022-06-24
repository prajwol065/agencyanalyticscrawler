<?php

namespace App\Http\Controllers;

use DOMDocument;
use App\Models\Crawl;
use App\Models\Image;
use App\Models\Webcrawler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebcrawlerController extends Controller
{
    private $streamContext;
    public function index()
    {
        $webcrawl = Webcrawler::all();
        if ($webcrawl->isEmpty()) {
            session()->flash('message', 'Website has not been crawled!!');
            return redirect()->route('home');
        } else {
            return view('webcrawl.index', ['webcrawl' => $webcrawl]);
        }
    }
    public function show()
    {
        $webcrawl = Webcrawler::all();
        $crawls = Crawl::all();
        $images = Image::all();
        if ($webcrawl->isEmpty()) {
            session()->flash('message', 'Website has not been crawled!!');
            return redirect()->route('home');
        } else {
            return view('webcrawl.show', ['webcrawl' => $webcrawl, 'images' => $images, 'crawls' => $crawls]);
        }
    }
    public function store()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Webcrawler::truncate();
        Crawl::truncate();
        Image::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->stremContext = stream_context_create(
            array(
                'http' =>
                array(
                    'timeout' => 180,
                )
            )
        );

        $url = "https://agencyanalytics.com";

        $file_headers = @get_headers($url, 1, $this->streamContext);


        $weblink = new Webcrawler();
        $weblink->page_url = $url;
        $weblink->http_code = $this->httpCodeParser($file_headers[0]);
        $weblink->save();


        $webcrawler = Webcrawler::where('page_url', $url)->first();

        if ($this->httpCodeParser($file_headers[0]) == 404) {
            session()->flash('message', 'Error: 404 NOT FOUND');
            exit;
        } else {
            $startTime = microtime(true);
            $this->linkCrawler($url, 0, $webcrawler);
            $endTime = microtime(true);
            $diffTime = $endTime - $startTime;
            $webcrawler->time_taken = $diffTime;
            $webcrawler->save();
            $this->secondaryPage($url, $webcrawler);
        }
        session()->flash('info', 'Crawling has been finished!!');
        return redirect()->route('webcrawl.index');
    }
    public function secondaryPage($url, Webcrawler $webcrawl)
    {
        $randomPageNumbers = random_int(3, 5);
        $extractedUrls = $webcrawl->crawls()->where([
            ['extracted_url', '<>', '/signup'],
            ['extracted_url', 'NOT LIKE', '%https%']
        ])
            ->inRandomOrder()
            ->limit($randomPageNumbers)
            ->get();
        foreach ($extractedUrls as $seconaryCrawlUrls) {
            $startTime = microtime(true);
            $file_headers = @get_headers($url . $seconaryCrawlUrls->extracted_url, 1, $this->streamContext);
            $weblink = new Webcrawler();
            $weblink->page_url = $seconaryCrawlUrls->extracted_url;
            $weblink->http_code = $this->httpCodeParser($file_headers[0]);
            $weblink->save();

            if ($this->httpCodeParser($file_headers[0]) == 404) {
                session()->flash('message', '404 NOT FOUND for secondary page crawls');
            } else {
                $this->linkCrawler($seconaryCrawlUrls->extracted_url, 1, $weblink);
                $endTime = microtime(true);
                $diffTime = $endTime - $startTime;
                $webcrawl = Webcrawler::where('page_url', $seconaryCrawlUrls->extracted_url)->first();
                $webcrawl->time_taken = $diffTime;
                $webcrawl->save();
            }
        }
    }

    public function linkCrawler($url, $secondary = 0, Webcrawler $webcrawler)
    {
        if ($secondary == 1) {
            $fullUrl = "https://agencyanalytics.com" . $url;
        }


        if (isset($fullUrl)) {
            $url = $fullUrl;
        }


        $data = file_get_contents($url, false, $this->streamContext);

        $search = array(
            '@<script[^>]*?>.*?</script>@si',  // Strip out javascript
            '@<head>.*?</head>@siU',            // Lose the head section
            '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
        );

        $data = preg_replace($search, '', $data);
        $this->wordCounter($data, $webcrawler);
        $htmlDom = new DOMDocument();
        @$htmlDom->loadHTML($data);
        $this->titleLength($htmlDom, $webcrawler);
        $this->imagesCrawler($htmlDom, $webcrawler);


        $content = strip_tags($data, "<a>");

        $linkStrings = preg_split("/<\/a>/", $content);
        foreach ($linkStrings as $link) {
            if (strpos($link, "<a href=") !== FALSE) {
                $link = preg_replace("/.*<a\s+href=\"/sm", "", $link);
                $link = preg_replace("/\".*/", "", $link);
                if (strpos($link, ' ') !== false) {
                    $linkPart = strstr($link, ' ', true);
                    $linkPart = preg_replace("/\s+/", "*", $linkPart);
                    $linkPart = strstr($linkPart, '*', true);
                    $input['extracted_url'] = $linkPart;
                } else {
                    $input['extracted_url'] = $link;
                }
                if (strpos($link, 'http') !== false) {
                    $input['is_internal'] = 0;
                } else {
                    $input['is_internal'] = 1;
                }



                $webcrawler->crawls()->create($input);
            }
        }
    }

    public function wordCounter($contents, Webcrawler $webcrawler)
    {


        $result =   str_word_count(strip_tags(strtolower($contents)));

        $webcrawler->word_count = $result;
        $webcrawler->save();
    }

    public function imagesCrawler($htmlDom, Webcrawler $webcrawl)
    {

        $imageTags = $htmlDom->getElementsByTagName('img');

        foreach ($imageTags as $imageTag) {
            $imgSrc = $imageTag->getAttribute('data-src');
            if (!empty($imgSrc)) {
                $input['image_url'] = $imgSrc;
                $webcrawl->images()->create($input);
            }
        }
    }
    public function titleLength($htmldom, Webcrawler $webcrawl)
    {
        $lengthOfTitle = [];
        for ($i = 1; $i <= 6; $i++) {
            foreach ($htmldom->getElementsByTagName('h' . $i) as $heading) {
                $h[$i] = $heading->nodeValue;
                array_push($lengthOfTitle, strlen(trim($h[$i])));
            }
        }

        $averageTitleLength = array_sum($lengthOfTitle) / count($lengthOfTitle);
        $webcrawl->average_title_length = (int)$averageTitleLength;
        $webcrawl->save();
    }
    public function httpCodeParser($codeString)
    {
        if (preg_match("#HTTP/[0-9\.]+\s+([0-9]+)#", $codeString, $result))
            $reponse_code = (int)$result[1];
        else
            $reponse_code = 0;
        return  $reponse_code;
    }
}

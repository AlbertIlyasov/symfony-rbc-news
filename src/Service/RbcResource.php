<?php


namespace App\Service;

class RbcResource implements ResourceInterface
{
    /** @var RbcClient */
    private $client;

    /** @var RbcParser */
    private $parser;

    public function __construct(RbcClient $client, RbcParser $parser)
    {
        $this->client = $client;
        $this->parser = $parser;
    }

    /**
     * @return News[]
     */
    public function getLastNews(): array
    {
        $lastNews = [];
        //without analyze already parsed urls
        $urls = $this->parser->parseUrls($this->client->getLastNews());
        foreach ($urls as $url) {
            $news = $this->parser->parseNews($this->client->getNews($url));
            if ($news) {
                $lastNews[] = $news;
//                break;
            }
        }
        return $lastNews;
    }
}

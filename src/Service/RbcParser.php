<?php


namespace App\Service;

use App\Entity\News;

class RbcParser
{
    const MAX_PARSE_LINKS = 15;

    /**
     * @param string $data
     * @return string[]
     */
    public function parseUrls(string $data): array
    {
        $regExp = '/<a href="([^"]+)"[^>]+data-yandex-name="from_news_feed">/s';
        preg_match_all($regExp, $data, $b);
        return array_slice($b[1], 0, self::MAX_PARSE_LINKS);
    }

    public function parseNews(string $data): ?News
    {
        $piece = explode('<div class="article__header__title">', $data);
        if (!isset($piece[1])) {
            return null;
        }
        $piece = explode('<div class="news-bar news-bar_article js-news-bar-desktop-bottom">', $piece[1]);
        $piece = $piece[0];

        return (new News)
            ->setTitle($this->parseTitle($piece))
            ->setText($this->parseTextOverview($piece) . $this->parseText($piece))
            ->setImg($this->parseImg($piece))
        ;
    }

    public function parseTitle(string $data): string
    {
        $regExp = '/<h1 class="article__header__title[^"]*"[^>]*>(.+)<\/h1>/s';
        preg_match($regExp, $data, $b);
        return $b[1];
    }

    public function parseTextOverview(string $data): string
    {
        //todo
        return '';
    }

    public function parseText(string $data): string
    {
        $regExp = '/<p>(.+?)<\/p>/s';
        preg_match_all($regExp, $data, $b);
        $p = $b[1];
        $p = array_map('strip_tags', $p);
        $p = array_map('trim', $p);
        $p = array_map(function ($item) {
            return '<p>' . $item . '</p>';
        }, $p);
        return implode($p);
    }

    public function parseImg(string $data): string
    {
        //todo
        return '';
    }
}

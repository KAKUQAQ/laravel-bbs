<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Link;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{
    protected array $links = [
        [
            'title' => 'Stack Overflow',
            'link' => 'https://stackoverflow.com',
        ],
        [
            'title' => 'Reddit - r/programming',
            'link' => 'https://www.reddit.com/r/programming/?rdt=61544',
        ],
        [
            'title' => 'Hacker News',
            'link' => 'https://news.ycombinator.com/',
        ],
        [
            'title' => 'Hack Forums',
            'link' => 'https://hackforums.net/',
        ],
        [
            'title' => '２ちゃんねる掲示板へようこそ',
            'link' => 'https://2ch.sc/',
        ],
        [
            'title' => 'The Laravel Blog ',
            'link' => 'https://blog.laravel.com/',
        ],
    ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return array_shift($this->links);
    }
}

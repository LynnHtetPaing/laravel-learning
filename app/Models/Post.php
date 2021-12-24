<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Post
{
    public $title;
    public $excerpt;
    public $date;
    public $body;
    public $slug;

    public function __construct($title, $excerpt, $date, $body, $slug)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
        $this->slug = $slug;
    }
    
    public static function all()
    {
        return cache()->rememberForever('posts.all', function () {
            /* Using collection more cleaner */
            return collect(File::files(resource_path("posts")))
            ->map(fn($file) => YamlFrontMatter::parseFile($file))
            ->map(fn($document) => new Post(
                    $document->title,
                    $document->excerpt,
                    $document->date,
                    $document->body(),
                    $document->slug
            ))
            ->sortByDesc('date');
        });

        /* More clearner style*/
        // $posts = array_map(function ($file){
        //     $document[] = YamlFrontMatter::parseFile($file);
        //     return new Post(
        //         $document->title,
        //         $document->excerpt,
        //         $document->date,
        //         $document->body(),
        //         $document->slug
        //     );
        // }, $files);

        /* a little bit messy code */
        // $posts = [];
        // foreach ($files as $key => $file)
        // {
        //     $document[] = YamlFrontMatter::parseFile($file);
        //     $posts[] = new Post(
        //         $document[$key]->title,
        //         $document[$key]->excerpt,
        //         $document[$key]->date,
        //         $document[$key]->body(),
        //         $document[$key]->slug
        //     );
        // }
    }
    
    public static function find($slug)
    {
        return static::all()->firstWhere('slug', $slug);
    }

    public static function findOrFail($slug)
    {
        $post = static::find($slug);
        if (! $post)
        {
            throw new ModelNotFoundException();
        }
        return $post;
    }
}

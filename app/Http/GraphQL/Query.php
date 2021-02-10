<?php

namespace App\Http\GraphQL;
use App\Models\Comment;

class Query {
  public function commentSearch($root, array $args) {
    $keyword = $args["keyword"];
    return Comment::where(function($query) use($keyword) {
      $query->where('name', 'like', '%' . $keyword . '%')
        ->orWhere('email', 'like', '%' . $keyword . '%')
        ->orWhere('body', 'like', '%' . $keyword . '%');
    })->get();
  }
}
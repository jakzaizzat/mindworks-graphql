<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $http = new \GuzzleHttp\Client();

        try {
            $response = $http->request('get', 'https://jsonplaceholder.typicode.com/comments');

            $result = (string) $response->getBody();
            $comments = json_decode($result, true);
            foreach ($comments as $key => $comment) {
                DB::table('comments')->insert([
                    'post_id' => $comment['postId'],
                    'id' => $comment['id'],
                    'name' => $comment['name'],
                    'email' => $comment['email'],
                    'body' => $comment['body'],
                ]);
            }
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
          return response()->json('Failed to import the data', $e->getCode());
        }
    }
}

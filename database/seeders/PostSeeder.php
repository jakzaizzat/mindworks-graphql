<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use DB;

class PostSeeder extends Seeder
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
            $response = $http->request('get', 'https://jsonplaceholder.typicode.com/posts');

            $result = (string) $response->getBody();
            $posts = json_decode($result, true);

            foreach ($posts as $post) {
                DB::table('posts')->insert([
                    'id' => $post['id'],
                    'user_id' => $post['userId'],
                    'title' => $post['title'],
                    'body' => $post['body'],
                ]);
            }
            return;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
          return response()->json('Failed to import the data', $e->getCode());
        }
    }
}

<?php

namespace App;

use GuzzleHttp\Exception\ClientException;
use App\Exceptions\RemoteException;

/**
 * Github implementation of RepoHost.
 *
 */
class GitHubRepoHost implements RepoHost {

    /**
     * Guzzle client for making api calls.
     */
    private $http;

    /**
     * Search $term in all files hosted in Github.
     *
     * @param $term string Query made to the repository host.
     * @param $maxhits integer Number of hits a page contains.
     * @param $page integer The index of the page.
     * @param $sort string Field the search results must be ordered by.
     *
     * @return array of SearchResults objects containing the hits asked for.
     */
    public function search($term, $maxHits=25, $page=0, $sort='score')
    {
        $query = [
            'q' => $term,
            'per_page' => $maxHits,
            'page' => $page,
            'sort' => $sort,
        ];

        $endpoint = '/search/code';
        $method = 'GET';

        /*
            FIXME: I know it's ugly showing default username and password, but
            there is a bug in Laravel 5.5 that makes that sometimes variables in
            .env are not loaded
        */
        $user = env('GITHUB_USERNAME', 'repohostsearch');
        $pass = env('GITHUB_PASSWORD', 'repo1host1search');

        try {
            $response = $this->http->request($method, $endpoint, [
                'query' => $query,
                'auth' => [ $user, $pass ],
            ]);
        } catch (ClientException $e){
            throw new RemoteException($e->getResponse()->getStatusCode(),
                $e->getMessage());
        }


        return $this->responseBodyToResults($response->getBody());

    }

    /**
     * Parse the body of the Github response into an array of SearchResult.
     *
     * @param $rb GuzzleHttp\Psr7\Stream body of the Github response
     *
     * @return array Array of SearchResult
     */
    private function responseBodyToResults($rb)
    {
        $results = array();
        $list = json_decode($rb);

        foreach($list->items as $item) {
            $results[] = $this->itemToResult($item);
        }

        return $results;

    }

    /**
     * Parse a single hit object into a SearchResult.
     *
     * @param object Hit object representing a single result
     *
     * @return SearchResult obtained from that object's attributes
     */
    private function itemToResult($item) {

        $owner = $item->repository->owner->login;
        $repo = $item->repository->name;
        $filename = $item->name;

        return new SearchResult($owner, $repo, $filename);
    }


    function __construct() {
        $this->http = new \GuzzleHttp\Client([
            'base_uri' => 'https://api.github.com',
        ]);
    }

}

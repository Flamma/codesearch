<?php

namespace Tests\External;

use Tests\TestCase;

/**
 * This class tests all the functionality depending on Github communication.
 */
class GithubRemoteTest extends TestCase
{
    /**
     * Test GithubRepoHost search method without arguments.
     */
    public function testSearch()
    {
        $grh = new \App\GithubRepoHost();

        $results = $grh->search('love');

        $this->assertNotNull($results);
        $this->assertInternalType('array', $results);
        $this->assertLessThanOrEqual(25, count($results),
            "The default max of hits should be 25. Got: ".count($results)."." );

        if(count($results) > 0) {
            $this->assertObjectHasAttribute('owner', $results[0]);
            $this->assertObjectHasAttribute('repo', $results[0]);
            $this->assertObjectHasAttribute('filename', $results[0]);
        }

    }

    /**
     * Test GithubRepoHost search method with maxhits argument.
     */
    public function testSearchMaxHits()
    {
        $grh = new \App\GithubRepoHost();

        $results = $grh->search('love', 2);

        $this->assertNotNull($results);
        $this->assertInternalType('array', $results);
        $this->assertLessThanOrEqual(2, count($results),
            "The max of hits should be 2. Got: ".count($results)."." );

        if(count($results) > 0) {
            $this->assertObjectHasAttribute('owner', $results[0]);
            $this->assertObjectHasAttribute('repo', $results[0]);
            $this->assertObjectHasAttribute('filename', $results[0]);
        }

    }

    /**
     * Test GithubRepoHost search method with maxhits and page arguments.
     */
    public function testSearchPage()
    {
        $grh = new \App\GithubRepoHost();

        $results = $grh->search('love', 25, 2);

        $this->assertNotNull($results);
        $this->assertInternalType('array', $results);
        $this->assertLessThanOrEqual(25, count($results),
            "The default max of hits should be 25. Got: ".count($results)."." );

        if(count($results) > 0) {
            $this->assertObjectHasAttribute('owner', $results[0]);
            $this->assertObjectHasAttribute('repo', $results[0]);
            $this->assertObjectHasAttribute('filename', $results[0]);
        }

    }

    /**
     * Test GithubRepoHost search method with maxhits, page and sort arguments.
     */
    public function testSearchSort()
    {
        $grh = new \App\GithubRepoHost();

        $results = $grh->search('love', 25, 2,'indexed');

        $this->assertNotNull($results);
        $this->assertInternalType('array', $results);
        $this->assertLessThanOrEqual(25, count($results),
            "The default max of hits should be 25. Got: ".count($results)."."
        );

        if(count($results) > 0) {
            $this->assertObjectHasAttribute('owner', $results[0]);
            $this->assertObjectHasAttribute('repo', $results[0]);
            $this->assertObjectHasAttribute('filename', $results[0]);
        }

    }

    /**
     * Test search endpoint without parameters
     */
    public function testSearchCall()
    {
        $response = $this->get('/api/search/love');

        $response->assertStatus(200);
        $response->assertJsonStructure([['owner', 'repo', 'filename']]);
    }

    /**
     * Test search endpoint with maxhits parameter
     */
    public function testSearchCallMaxhits()
    {
        $response = $this->get('/api/search/love?maxhits=2');
        $response->assertStatus(200);
        $response->assertJsonStructure([['owner', 'repo', 'filename']]);
        $this->assertLessThanOrEqual(2, count($response->original),
            "Response contains more results than asked for: ".
                count($response->original)."."
        );
    }

}

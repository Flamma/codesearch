<?php

namespace App;

/**
 * This interface is meant for classes that wrap Repository Hosts communication.
 */
interface RepoHost {

    /**
     * Search $term in all files hosted in the Repository Host.
     *
     * @param $term string Query made to the repository host.
     * @param $maxhits integer Number of hits a page contains.
     * @param $page integer The index of the page.
     * @param $sort string Field the search results must be ordered by.
     *
     * @return array of SearchResults objects containing the hits asked for.
     */
    public function search($term, $maxHits=25, $page=0, $sort='score');

}  

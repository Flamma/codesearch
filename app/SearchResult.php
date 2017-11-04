<?php

namespace App;

/**
 * This class is a container for the fields that are required in the response.
 *
 */
class SearchResult
{
    /**
     * string Username of the owner of the repository.
     */
    public $owner;
    /**
     * string Repository that contains the file.
     */
    public $repo;
    /**
     * string File name containing the search term.
     */
    public $filename;

    public function __construct($owner, $repo, $filename) {
        $this->owner = $owner;
        $this->repo = $repo;
        $this->filename = $filename;
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RepoHost;

class RepoHostController extends Controller
{
    /**
     * Make the RepoHost search for the term.
     *
     */
    public function search(Request $request, RepoHost $rh, $term)
    {
        $args = $request->all();

        $maxhits = isset($args['maxhits']) ? $args['maxhits'] : 25;
        $page = isset($args['page']) ? $args['page'] : 0;
        $sort = isset($args['sort']) ? $args['sort'] : 'score';

        return $rh->search($term, $maxhits, $page, $sort);

    }
}

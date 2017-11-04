<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\GithubRepoHost;

/**
 * This class test the parse of Github responses, mocking them.
 *
 * No actual communication is made in this test.
 */
class GithubParseTest extends TestCase
{
    /**
     * Test GithubRepoHost itemToResult method.
     */
    public function testItemToResult()
    {
        $expected = $this->mockResult();

        $item = $this->mockItem();

        $itemToResult = self::getMethod('itemToResult');
        $grh = new GithubRepoHost();
        $result = $itemToResult->invokeArgs($grh, [$item]);

        $this->assertEquals($expected, $result);
    }

    /**
     * Test GithubRepoHost responseBodyToResults method.
     */
    public function testResponseBodyToResults()
    {
        $expected = $this->mockResultSet();

        $rb = $this->mockResponseBody();

        $responseBodyToResults = self::getMethod('responseBodyToResults');
        $grh = new GithubRepoHost();
        $result = $responseBodyToResults->invokeArgs($grh, [$rb]);

        $this->assertEquals($expected, $result);


    }

    private function mockItem()
    {
        $owner = new Owner();
        $repo = new Repository($owner);
        $item = new Item($repo);

        return($item);

    }

    private function mockResult()
    {
        return new \App\SearchResult('test', 'repotest', 'test.php');
    }

    private function mockResultSet()
    {
        $resultSet = [];

        for($i=0; $i<25; $i++) {
            $resultSet[] = $this->mockResult();
        }

        return $resultSet;

    }

    private function mockResponseBody()
    {
        $items = [];
        for($i=0; $i<25; $i++) {
            $items[] = $this->mockItem();
        }

        return json_encode(new ResponseBody($items));

    }


    protected static function getMethod($name)
    {
        $class = new \ReflectionClass('App\GithubRepoHost');
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }
}

class Owner
{
    public $login;
    public $id;
    public $avatar_url;
    public $gravatar_id;
    public $url;
    public $html_url;
    public $followers_url;
    public $following_url;
    public $gists_url;
    public $starred_url;
    public $subscriptions_url;
    public $organizations_url;
    public $repos_url;
    public $events_url;
    public $received_events_url;
    public $type;
    public $site_admin;

    public function __construct()
    {
        $this->login = 'test';
        $this->id = 123456;
        $this->avatar_url = 'https://avatars0.githubusercontent.com/u/123456?v=4';
        $this->gravatar_id = '';
        $this->url = 'https://api.github.com/users/test';
        $this->html_url = 'https://github.com/users/test';
        $this->followers_url = 'https://api.github.com/users/test/followers';
        $this->following_url = 'https://api.github.com/users/test/following{/other_user}';
        $this->gists_url = 'https://api.github.com/users/test/gists{/gist_id}';
        $this->starred_url = 'https://api.github.com/users/test/starred{/owner}{/repo}';
        $this->subscriptions_url = 'https://api.github.com/users/test/subscriptions';
        $this->organizations_url = 'https://api.github.com/users/test/orgs';
        $this->repos_url = 'https://api.github.com/users/test/repos';
        $this->events_url = 'https://api.github.com/users/test/events{/privacy}';
        $this->received_events_url = 'https://api.github.com/users/test/received_events';
        $this->type = 'User';
        $this->site_admin = '';
    }
}

class Repository
{
    public $id;
    public $name;
    public $full_name;
    public $owner;
    public $private;
    public $html_url;
    public $description;
    public $fork;
    public $url;
    public $forks_url;
    public $keys_url;
    public $collaborators_url;
    public $teams_url;
    public $hooks_url;
    public $issue_events_url;
    public $events_url;
    public $assignees_url;
    public $branches_url;
    public $tags_url;
    public $blobs_url;
    public $git_tags_url;
    public $git_refs_url;
    public $trees_url;
    public $statuses_url;
    public $languages_url;
    public $stargazers_url;
    public $contributors_url;
    public $subscribers_url;
    public $subscription_url;
    public $commits_url;
    public $git_commits_url;
    public $comments_url;
    public $issue_comment_url;
    public $contents_url;
    public $compare_url;
    public $merges_url;
    public $archive_url;
    public $downloads_url;
    public $issues_url;
    public $pulls_url;
    public $milestones_url;
    public $notifications_url;
    public $labels_url;
    public $releases_url;
    public $deployments_url;

    public function __construct($owner)
    {
        $this->id = '12345678';
        $this->name = 'repotest';
        $this->full_name = 'test/repotest';
        $this->owner = $owner;
        $this->private = '';
        $this->html_url = 'https://github.com/test/repotest';
        $this->description = 'Linux-based Network Bootmanager';
        $this->fork = '';
        $this->url = 'https://api.github.com/repos/test/repotest';
        $this->forks_url = 'https://api.github.com/repos/test/repotest/forks';
        $this->keys_url = 'https://api.github.com/repos/test/repotest/keys{/key_id}';
        $this->collaborators_url = 'https://api.github.com/repos/test/repotest/collaborators{/collaborator}';
        $this->teams_url = 'https://api.github.com/repos/test/repotest/teams';
        $this->hooks_url = 'https://api.github.com/repos/test/repotest/hooks';
        $this->issue_events_url = 'https://api.github.com/repos/test/repotest/issues/events{/number}';
        $this->events_url = 'https://api.github.com/repos/test/repotest/events';
        $this->assignees_url = 'https://api.github.com/repos/test/repotest/assignees{/user}';
        $this->branches_url = 'https://api.github.com/repos/test/repotest/branches{/branch}';
        $this->tags_url = 'https://api.github.com/repos/test/repotest/tags';
        $this->blobs_url = 'https://api.github.com/repos/test/repotest/git/blobs{/sha}';
        $this->git_tags_url = 'https://api.github.com/repos/test/repotest/git/tags{/sha}';
        $this->git_refs_url = 'https://api.github.com/repos/test/repotest/git/refs{/sha}';
        $this->trees_url = 'https://api.github.com/repos/test/repotest/git/trees{/sha}';
        $this->statuses_url = 'https://api.github.com/repos/test/repotest/statuses/{sha}';
        $this->languages_url = 'https://api.github.com/repos/test/repotest/languages';
        $this->stargazers_url = 'https://api.github.com/repos/test/repotest/stargazers';
        $this->contributors_url = 'https://api.github.com/repos/test/repotest/contributors';
        $this->subscribers_url = 'https://api.github.com/repos/test/repotest/subscribers';
        $this->subscription_url = 'https://api.github.com/repos/test/repotest/subscription';
        $this->commits_url = 'https://api.github.com/repos/test/repotest/commits{/sha}';
        $this->git_commits_url = 'https://api.github.com/repos/test/repotest/git/commits{/sha}';
        $this->comments_url = 'https://api.github.com/repos/test/repotest/comments{/number}';
        $this->issue_comment_url = 'https://api.github.com/repos/test/repotest/issues/comments{/number}';
        $this->contents_url = 'https://api.github.com/repos/test/repotest/contents/{+path}';
        $this->compare_url = 'https://api.github.com/repos/test/repotest/compare/{base}...{head}';
        $this->merges_url = 'https://api.github.com/repos/test/repotest/merges';
        $this->archive_url = 'https://api.github.com/repos/test/repotest/{archive_format}{/ref}';
        $this->downloads_url = 'https://api.github.com/repos/test/repotest/downloads';
        $this->issues_url = 'https://api.github.com/repos/test/repotest/issues{/number}';
        $this->pulls_url = 'https://api.github.com/repos/test/repotest/pulls{/number}';
        $this->milestones_url = 'https://api.github.com/repos/test/repotest/milestones{/number}';
        $this->notifications_url = 'https://api.github.com/repos/test/repotest/notifications{?since,all,participating}';
        $this->labels_url = 'https://api.github.com/repos/test/repotest/labels{/name}';
        $this->releases_url = 'https://api.github.com/repos/test/repotest/releases{/id}';
        $this->deployments_url = 'https://api.github.com/repos/test/repotest/deployments';

    }

}

class Item
{
    public $name;
    public $path;
    public $sha;
    public $url;
    public $git_url;
    public $html_url;
    public $repository;
    public $score;

    public function __construct($repo)
    {
        $this->name = 'test.php';
        $this->path = 'path/test.c';
        $this->sha = '6d1a0d47b7f73eacb962f3711df06b21ed11f7ca';
        $this->url = 'https://api.github.com/repositories/12345678/contents/Sources/path/test.php?ref=52abb8b8ef6155a529b664a95708c6bb3f6b759b';
        $this->git_url = 'https://api.github.com/repositories/12345678/git/blobs/6d1a0d47b7f73eacb962f3711df06b21ed11f7ca';
        $this->html_url = 'https://github.com/test/repotest/blob/52abb8b8ef6155a529b664a95708c6bb3f6b759b/Sources/path/test.php';
        $this->repository = $repo;
        $this->score = '3.1726189';
    }
}

class ResponseBody
{
    public $total_count;
    public $incomplete_results;
    public $items;

    public function __construct($items)
    {
        $this->total_count = 1000;
        $this->incomplete_results = 1;
        $this->items = $items;
    }
}

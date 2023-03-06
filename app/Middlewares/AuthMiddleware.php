<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\Post;
use App\Repositories\PostRepository;
class AuthMiddleware
{
    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }


    public function __invoke(Request $request, Response $response, $next)
    {
        // Check if the user is logged in
        if (!isset($_SESSION['user'])) {
            // Redirect to the login page if not logged in
            return $response->withRedirect('/login');
        }

        if (isset($_SESSION['user'])) {
            $routePattern = $request->getAttribute('route')->getPattern();
            $granted = true;
            if(strpos($routePattern, '/posts') === 0) {
                $granted = $this->checkPostUserPermissions($request, $response);
            }   else if(strpos($routePattern, '/users') === 0) {
                $granted = $this->checkPageUserPermissions($request, $response);
         }
         if(!$granted){
            return $response->withStatus(403)->write('You do not have permission to access this post.');
         }
        // Call the next middleware in the chain
        $response = $next($request, $response);

        return $response;
        }
    }

    public function checkPostUserPermissions (Request $request, Response $response)
    {
        $userId = $_SESSION['user']['id'];
        $postId = $request->getAttribute('route')->getArgument('id');
        if($postId) {
            $post_data = $this->post->getById($postId);
            if (!$post_data || $post_data['user_id'] !== $userId) {
                return false;
            }
        }
        return true;
    }
    public function checkPageUserPermissions (Request $request, Response $response) {
        // Check if the user has permission to access the post
        $userId = $_SESSION['user']['id'];
        $id = $request->getAttribute('route')->getArgument('id');
        if ($id !== $userId) {
            return false;
        }
        return true;
    }
}

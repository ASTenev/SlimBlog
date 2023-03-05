<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AuthMiddleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        // Check if the user is logged in
        if (!isset($_SESSION['user'])) {
            // Redirect to the login page if not logged in
            return $response->withRedirect('/login');
        }

        if (isset($_SESSION['user'])) {

            // Check if the user has permission to access the post
            $postId = $request->getAttribute('id');
            $userId = $_SESSION['user']['id'];
            $post = $this->getPostById($postId);

            if (!$post || $post['user_id'] !== $userId) {
                // Return a 403 Forbidden response if the user does not have permission
                return $response->withStatus(403)->write('You do not have permission to access this post.');
            }
        }
        // Call the next middleware in the chain
        $response = $next($request, $response);

        return $response;
    }

    private function getPostById($id)
    {
        // Retrieve the post from the database by its ID
        // You can use your existing PostModel and Repository classes to do this
    }
}

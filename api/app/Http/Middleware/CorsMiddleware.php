<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class CorsMiddleware {

	protected $settings = [
		'origin' => '*',
		'allowMethods' => 'GET,HEAD,PUT,POST,DELETE,PATCH,OPTIONS',
        'allowHeaders' => 'Content-Type',
        'maxAge' => 1000
	];

	protected function setOrigin($request, $response) {
		$origin = $this->settings['origin'];
		if (is_callable($origin)) {
			// Call origin callback with request origin
			$origin = call_user_func($origin,
				$request->header("Origin")
			);
		}
		$response->header('Access-Control-Allow-Origin', $origin);
	}

    protected function setExposeHeaders($request, $response) {
        if (isset($this->settings['exposeHeaders'])) {
            $exposeHeaders = $this->settings['exposeHeaders'];
            if (is_array($exposeHeaders)) {
                $exposeHeaders = implode(",", $exposeHeaders);
            }

            $response->header('Access-Control-Expose-Headers', $exposeHeaders);
        }
    }

    protected function setMaxAge($request, $response) {
        if (isset($this->settings['maxAge'])) {
            $response->header('Access-Control-Max-Age', $this->settings['maxAge']);
        }
    }

    protected function setAllowCredentials($request, $response) {
        if (isset($this->settings['allowCredentials']) && $this->settings['allowCredentials'] === True) {
            $response->header('Access-Control-Allow-Credentials', 'true');
        }
    }

    protected function setAllowMethods($request, $response) {
        if (isset($this->settings['allowMethods'])) {
            $allowMethods = $this->settings['allowMethods'];
            if (is_array($allowMethods)) {
                $allowMethods = implode(",", $allowMethods);
            }

            $response->header('Access-Control-Allow-Methods', $allowMethods);
        }
    }

    protected function setAllowHeaders($request, $response) {
        if (isset($this->settings['allowHeaders'])) {
            $allowHeaders = $this->settings['allowHeaders'];
            if (is_array($allowHeaders)) {
                $allowHeaders = implode(",", $allowHeaders);
            }
        }
        else {  // Otherwise, use request headers
            $allowHeaders = $request->header("Access-Control-Request-Headers");
        }

        if (isset($allowHeaders)) {
            $response->header('Access-Control-Allow-Headers', $allowHeaders);
        }
    }

    protected function setCorsHeaders($request, $response) {
        if ($request->method() == 'OPTIONS') {
            $this->setOrigin($request, $response);
            $this->setMaxAge($request, $response);
            $this->setAllowCredentials($request, $response);
            $this->setAllowMethods($request, $response);
            $this->setAllowHeaders($request, $response);
        }
        else {
            $this->setOrigin($request, $response);
            $this->setExposeHeaders($request, $response);
            $this->setAllowCredentials($request, $response);
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if ($request->method() == 'OPTIONS') {
            $response = new Response("", 200);
        } else {
            $response = $next($request);
        }

        $this->setCorsHeaders($request, $response);
        return $response;
    }

}

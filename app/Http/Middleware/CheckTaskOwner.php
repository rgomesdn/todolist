<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Task;

class CheckTaskOwner
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->segments()[0] === 'api'){
            $task = json_decode(Task::findOrFail($request->id)->toJson(JSON_PRETTY_PRINT));

            if ($task->user_id !== $request->user_id) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            $task = json_decode(Task::findOrFail($request->segments()[2])->toJson(JSON_PRETTY_PRINT));

            if ($task->user_id !== Auth()->user()->id) {
                abort(403, 'Unauthorized action.');
            }
        }



        return $next($request);
    }
}

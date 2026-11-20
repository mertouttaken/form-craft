<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

/**
 * Links that leave out {workspace} (the header's "Formlar" and "Üyeler")
 * stay in the workspace the page belongs to. Outside a workspace URL they
 * go to the signed-in user's own workspace, not the seeded sample one.
 */
class SetWorkspaceUrlDefaults
{
    public function handle(Request $request, Closure $next): Response
    {
        $workspace = $request->route('workspace');

        if (is_string($workspace) && $workspace !== '') {
            URL::defaults(['workspace' => $workspace]);
        } elseif ($user = $request->user()) {
            URL::defaults(['workspace' => $user->personalWorkspace()->slug]);
        }

        return $next($request);
    }
}

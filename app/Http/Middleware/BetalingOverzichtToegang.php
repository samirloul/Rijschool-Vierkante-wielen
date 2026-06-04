<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class BetalingOverzichtToegang
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $email = (string) optional($request->user())->email;

        if ($email === '') {
            abort(403);
        }

        try {
            $gebruiker = DB::table('Gebruiker')
                ->select('Rol')
                ->where('Email', $email)
                ->first();
        } catch (QueryException $exception) {
            report($exception);

            // Avoid 500 in environments where the custom Vierkante_Wielen schema
            // is not loaded yet (e.g. sqlite migrate:fresh).
            abort(403, 'Betaling overzicht is nog niet beschikbaar. Importeer eerst de Vierkante_Wielen database en stored procedure.');
        }

        $toegestaneRollen = ['Administrator', 'Instructeur'];

        if (! $gebruiker || ! in_array($gebruiker->Rol, $toegestaneRollen, true)) {
            abort(403);
        }

        return $next($request);
    }
}

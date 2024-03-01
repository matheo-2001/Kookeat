<?php

namespace App\Http\Middleware;

use App\Services\UserService;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtToken
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorizationHeader = $request->header('Authorization');
        $jwtToken = substr($authorizationHeader, 7);
        $publicKeys = $this->getFirebasePublicKeys();
        $decodedToken = null;

        foreach ($publicKeys as $kid => $publicKey) {
            try {
                $decodedToken = JWT::decode($jwtToken, new Key($publicKey, 'RS256'));
                break; // Sortir de la boucle si le token est valide
            } catch (\Exception $e) {
                // Gérer les exceptions, par exemple une signature invalide
            }
        }

        if ($decodedToken) {
            $userId = $decodedToken->user_id;
            UserService::setUserId($userId);
            return $next($request);
        } else {
            return response()->json(['error' => 'Token invalide'], 401);
        }
    }

    private function getFirebasePublicKeys()
    {
        $client = new Client();
        $response = $client->get('https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com');
        return json_decode((string)$response->getBody(), true);
    }
}

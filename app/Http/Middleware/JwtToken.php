<?php

namespace App\Http\Middleware;

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
        $jwtToken = "eyJhbGciOiJSUzI1NiIsImtpZCI6IjNiYjg3ZGNhM2JjYjY5ZDcyYjZjYmExYjU5YjMzY2M1MjI5N2NhOGQiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL3NlY3VyZXRva2VuLmdvb2dsZS5jb20va29va2VhdC1iMjA5YiIsImF1ZCI6Imtvb2tlYXQtYjIwOWIiLCJhdXRoX3RpbWUiOjE3MDkyMjE3MjksInVzZXJfaWQiOiI4eko3aWdPNkt6UzV3SmRScVMzZU5xQTdxb3AyIiwic3ViIjoiOHpKN2lnTzZLelM1d0pkUnFTM2VOcUE3cW9wMiIsImlhdCI6MTcwOTIyMTcyOSwiZXhwIjoxNzA5MjI1MzI5LCJlbWFpbCI6Im5pY29AZ21haWwuY29tIiwiZW1haWxfdmVyaWZpZWQiOmZhbHNlLCJmaXJlYmFzZSI6eyJpZGVudGl0aWVzIjp7ImVtYWlsIjpbIm5pY29AZ21haWwuY29tIl19LCJzaWduX2luX3Byb3ZpZGVyIjoicGFzc3dvcmQifX0.Trt9JEzEjapxDn9Msshq0AjPNFtVr5hRCbPW9Q6AIp4SmD0rMxggu1XHMuPr5JHEwS6c6mqSFc855_ICV0Io-bhjk2_psDDUIP0ZaT67_8hZlnb83YxcyPSfAt1WZBwJkT7z1ZN9qAQcLDg1qlYjbu1QAAP1VKfOUO_ucLeJszb0P9jUshVceFbYFv-API8RnN4wQTAGt_0cmPfxM0aif9VLsZEn3fCA-LvXpN7iFTldYO1ggMaycJ4oW0AS0lw8A3aYgheV_vSSk5OGqhr22ujiUR_tDxoxDWNCJ4Wl2vymQMVEFPsCPMaq_84gnj3QiAE9ZkyPlFh_Jh7QAGQA";
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
            // Le token est valide, traiter les données du token ici
            return response()->json(['message' => 'Token valide', 'data' => $decodedToken]);
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

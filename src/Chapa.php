<?php

namespace Semernur\Chapa;

use Illuminate\Support\Facades\Http;

class Chapa
{
    protected $public_key;
    protected $base_url;
    // we need $tx_ref because we might need to verify
    //payment
    protected $tx_ref;


    public function __construct(string $public_key = NULL)
    {
        //Chapa might will change their url 
        //so U don't have to refactor the whole code
        //base_url will be the current chapa url by default
        //incase their is change in chapa url
        //the only thing you need is define CHAPA_ENDPOINT=url.to.chapa

        if ($public_key) {
            $this->public_key = "Bearer " . $public_key;
        }
        $this->public_key = "Bearer " . config("CHAPA_PUBLIC_KEY");

        $this->base_url = config("CHAPA_ENDPOINT");
    }


    public function initializePayment(array $details)
    {
        //The array should have to be associative

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->public_key
            ])->post(
                $this->base_url . '/transaction/initialize',
                $details
            );
            return $response;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function verifyPayment(string $tx_ref, bool $only_status = FALSE)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer " . $this->public_key
            ])->get(
                $this->base_url . '/transaction/verify/' . $tx_ref
            );
            if ($only_status) {
                return  $response->object()->status == 'success' ? true : false;
            }
            return $response;
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    protected function redirectForCheckout(string $url)
    {
        //laravel's way to redirect

        return redirect($url);
        ##############################################

        //Js's method
        // echo '<script>window.open("' . $url . '","_blank")</script>';
    }
    protected function generateReference(string $ref_prefix = NULL, bool $short = true): string
    {
        //the purpose of $short is to specify the length of the ref
        // read more about uniqid
        // https://www.php.net/manual/en/function.uniqid.php
        if ($ref_prefix) {
            return $this->tx_ref = $ref_prefix . "_" . uniqid(time(), $short);
        }
        return $this->tx_ref = uniqid(time(), $short);
    }
}

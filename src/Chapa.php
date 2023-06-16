<?php

namespace Semernur\Chapa;

use Illuminate\Support\Facades\Http;
use Semernur\Chapa\Exceptions\ChapaException;

class Chapa
{
    protected $secret_key;
    protected $base_url;
    // we need $tx_ref because we might need to verify
    //payment
    protected $tx_ref;


    public function __construct(string $secret_key = NULL)
    {
        //Chapa might will change their url 
        //so U don't have to refactor the whole code
        //base_url will be the current chapa url by default
        //incase their is change in chapa url
        //the only thing you need is define CHAPA_ENDPOINT=url.to.chapa

        if ($secret_key) {
            $this->secret_key = "Bearer " . config("chapa.CHAPA_SECRET_KEY");
        }
        $this->secret_key = "Bearer " . config("chapa.CHAPA_SECRET_KEY");

        $this->base_url = config("chapa.CHAPA_ENDPOINT");
    }


    public function initializePayment(array $details, $will_redirect = FALSE)
    {

        $response = Http::withHeaders([
            'Authorization' => $this->secret_key
        ])->post(
            $this->base_url . '/transaction/initialize',
            $details
        );
        if ($response->status() === 200) {

            if ($will_redirect) {
                $this->redirectForCheckout($response->object()->data->checkout_url);
                return $response;
            }
        }

        return $response;
    }

    public function verifyPayment(string $tx_ref, bool $only_status = FALSE)
    {

        $response = Http::withHeaders([
            'Authorization' => "Bearer " . $this->secret_key
        ])->get(
            $this->base_url . '/transaction/verify/' . $tx_ref
        );
        if ($only_status) {
            return  $response->object()->status == 'success' ? true : false;
        }
        return $response;
    }



    protected function redirectForCheckout(string $url)
    {
        //laravel's way to redirect

        // return redirect($url);
        ##############################################

        //Js's method
        // Recommended way
        //this will open the checkout url in new tab
        echo '<script>window.open("' . $url . '","_blank")</script>';
    }
    public function generateReference(string $ref_prefix = NULL, bool $short = true): string
    {
        //the purpose of $short is to specify the length of the ref
        // read more about uniqid
        // https://www.php.net/manual/en/function.uniqid.php
        if ($ref_prefix) {
            return $this->tx_ref = uniqid("$ref_prefix _" . time(), $short);
        }
        return $this->tx_ref = uniqid(time(), $short);
    }
}

<?php

namespace Chapa\Controller;

use App\Http\Controllers\Controller;
use Chapa\Model\Chapa;
use Illuminate\Support\Facades\Http;


class ChapaController extends Controller
{
    protected $api_key;
    protected $base_url;
    // we need $tx_ref because we might need to verify
    //payment
    protected $tx_ref;


    public function __construct(string $api_key = NULL)
    {
        //Chapa might will change their url 
        //so U don't have to refactor the whole code
        //base_url will be the current chapa url by default
        //incase their is change in chapa url
        //the only thing you need is define CHAPA_URL=url.to.chapa
        $this->base_url = env("CHAPA_URL", "https://api.chapa.co/v1");
        if ($api_key) {

            return $this->api_key = "Bearer " . $api_key;
        }

        return $this->api_key = "Bearer " . env('CHAPA_API_KEY');
    }


    public function initializePayment(array $details, bool $will_redirect = FALSE, string $custom_ref = NULL, string $ref_prefix = NULL)
    {
        //The array should have to be associative

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->api_key
            ])->post(
                $this->base_url . '/transaction/initialize',
                [

                    'amount' => $details['amount'],
                    'currency' => $details['currency'],
                    'email' => $details['email'],
                    'first_name' => $details['first_name'],
                    'last_name' => $details['last_name'],
                    'tx_ref' => $custom_ref ? $custom_ref : $this->generateReference($ref_prefix),
                    'callback_url' => isset($details['callback_url']) ? $details['callback_url'] : null,
                    'customization[title]' => isset($details['title']) ? $details['title'] : null,
                    'customization[description]' => isset($details['description']) ? $details['description'] : null


                ]
            );
            if ($response->status() === 200) {
                Chapa::create(
                    [
                        'email' => $details['email'],
                        'amount' => $details['amount'],
                        'tx_ref' => isset($details['customRef']) ? $details['customRef'] : $this->tx_ref
                    ]
                );
                if ($will_redirect) {
                    return $this->redirectForCheckout($response->object()->data->checkout_url);
                }
            }
            return $response;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function verifyPayment(string $tx_ref, bool $only_status = FALSE)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer " . $this->api_key
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

    public function verifyLatestTx(bool $only_status = FALSE)
    {
        try {
            $latest = Chapa::latest()->first();
            $response = Http::withHeaders([
                'Authorization' => "Bearer " . $this->api_key
            ])->get(
                $this->base_url . '/transaction/verify/' . $latest->tx_ref

            );
            if ($only_status) {
                return  $response->object()->status == 'success' ? true : false;
            }


            return $response;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function verifyTxById(int $id, bool $only_status = FALSE)
    {
        $tx = Chapa::find($id);
        try {
            if ($tx) {


                $response = Http::withHeaders([
                    'Authorization' => "Bearer " . $this->api_key
                ])->get(
                    $this->base_url . '/transaction/verify/' . $tx->tx_ref

                );
                if ($only_status) {
                    return  $response->object()->status == 'success' ? true : false;
                }

                return $response;
            } else {
                return json_encode(['status' => 'Not found']);
            }
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

<?php

namespace Chapa\Controller;

use App\Http\Controllers\Controller;
use Chapa\Controller\ChapaController;



class Test extends Controller
{
    public $chapa;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->chapa = new ChapaController(env('CHAPA_API_KEY'));
    }

    public function initialize()
    {
        $this->chapa->initializePayment([
            'amount' => '100',
            'currency' => 'ETB',
            'email' => 'abebe@bikila.com',
            'first_name' => 'Abebe',
            'last_name' => 'Bikila',
            'tx_ref' => 'tx-myecommerce12345',
            'callback_url' => 'https://chapa.co',
            'title' => 'I love e-commerce',
            'description' => 'It is time to pay'
        ], TRUE);
    }

    public function verify($ref)
    {
        echo $this->chapa->verifyPayment($ref);
    }
    public function verifyById($id)
    {
        echo $this->chapa->verifyTxById($id);
    }
    public function latest()
    {

        echo $this->chapa->verifyLatestTx();
    }
}

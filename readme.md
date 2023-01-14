<p align="center" style="display:flex; margin-left:20%">
  <img src="https://ethiopianlogos.com/logos/chapa/chapa.svg" width="200" style="margin-right:30px" />
  <img src="https://www.svgrepo.com/show/353985/laravel.svg" width="50" />

</p>

<h1 align="center">
Chapa Package for Laravel
</h1>
 Chapa is one of the payment gateways in Ethiopia. This laravel SDK will help you integrate chapa with your next laravel project.You can find the package at packagist repo install with 
 
 >composer require semernur/chapa
 
 This package has functionalities that will help you to easily initialize payment,verify payment at the momment and other functionalities will be added very soon .
 <h1 align="center">
Docs
</h1>
First thing is first before you start using this package you need to have Chapa API key which you can get one from

[Chapa](https://dashboard.chapa.co/)

> make things as flexible as they could be.

Once you get your API key add your secret key inside .env file or You can pass it directly to the constructor.if you are using the former method which is accessing via .env file the variable should have name `CHAPA_API_KEY` .
After successful installation you need to run `php artisan migrate` in order to setup database table for the package.
if you would like to interact with the packages database run `php artisan vendor:publish --tag=database`
To interact with the packages model run `php artisan vendor:publish --tag=model`
To interact with the packages Controller run `php artisan vendor:publish --tag=controller`.

<h1 align="center">
Available Methods
</h1>

`initializePayment(array $details, bool $will_redirect = FALSE, string $custom_ref = NULL, string $ref_prefix = NULL)`

$details details you need to initialize in chapa's API.This array should have to be associative array which will help you in case you forget one of the required fields before making the request it will throw an error when of the required fields are null.
**You don't need to pass authorization tokens!**
$will_redirect if set to true it will redirect customer to the checkout_url automatically if the payment initialization was successful.

$custom_ref if not NULL `initializePayment` will use $custom_ref for chapa\`s `tx_ref` field.

if $custom_ref is not defined and $ref_prefix is defined `initializePayment` will generate unique tx_ref with prefix `$ref_prefix`.
**Note:-** `initializePayment` will return Chapa\`s response/object if `$will_redirect` is not set to true

`verifyPayment(string $tx_ref, bool $only_status = FALSE)`

This method will verify payment require `$tx_ref` transaction reference to the transaction need to be verified.One best feature of this package is it will store all initialized payment. So you don\`t need to worry about tx_ref loses.If `$only_status` set to true it only return the status of the transaction **TRUE** if the transaction status is **success** false otherwise.

`verifyLatestTx(bool $only_status = FALSE)`
sometimes you might only need to verify the latest transaction. `$only_status` optional variable same usage as it is in the above method.

`verifyTxById(int $id, bool $only_status = FALSE)`

sometimes your hands might get tired of writing long transaction ref when you do so the only thing you need is passing database id of your transaction. `$only_status` optional is set to true again same purpose.

<h1 align="center">Enjoy!</h1>

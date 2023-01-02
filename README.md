
<p float="middle" style="display:flex; margin-left:20%">
  <img src="https://ethiopianlogos.com/logos/chapa/chapa.svg" width="200" style="margin-right:30px" />
  <img src="https://www.svgrepo.com/show/353985/laravel.svg" width="50" /> 

</p>


<h1 style="text-align:center; color:green;">
Chapa SDK for Laravel
</h1>
 Chapa is one of the payment gateways in Ethiopia. This laravel SDK will help you integrate chapa with your next laravel project.You can find the package at packagist store. This package has functionalities that will help initialize payment,verify payment at the momment and other functionalities will be added very soon .
 <h1 style="text-align:center; color:green;">
Docs
</h1>
First thing is first before you start using this package you need to have Chapa API key which you cand get one from here [Here](https://dashboard.chapa.co/ "Here").

>make things as felxible as they could be.

Once you get your API key add your secret key inside .env file or You can pass it directely to the contructor.if you are using the former method which is accessing via .env file the variable should have name `CHAPA_API_KEY` .

<h2 style="text-align:center;">Available methods</h2>
```php
initializePayment(array $details, bool $will_redirect = FALSE, string $custom_ref = NULL, string $ref_prefix = NULL)
```

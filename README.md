# php-router
Een simpele PHP router met Controller Support
**deze package is niet op composer, maar ik ben van plan het er op te plaatsen indien ik tijd heb.**
Dit project is ook te vinden op mijn portfolio

[https://chrisvanlier.nl/content/custom-mvc-php-router](https://chrisvanlier.nl/content/custom-mvc-php-router)

## features
- Routes aanmaken en binden aan een URL
- Routes doorsturen naar URL
- Url parameters meesturen in een Route
- Url parameters uit url halen
- Request class injecteren indien nodig
- Controller support
- View layouts

Hier is een simpel voorbeeld:

```php
use App\Controllers\PageController;
use App\Controllers\UserController;
use chrisvanlier2005\Router as Route;
Route::get('/', [PageController::class, "index"]);
Route::prefix('/users', function () {
    Route::get('/', [UserController::class, "index"]);
    Route::get('/{id}', [UserController::class, "show"]);
});
Route::get('/{id}', [PageController::class, "show"]);


Route::notFound(function(){
    echo "404";
});
```

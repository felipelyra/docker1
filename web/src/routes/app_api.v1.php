<?

use App\Product;
use App\Brand;
use Illuminate\Support\Facades\Config; 


Route::get('/brands', function () {
    return Brand::select('id', 'brand')->get();
});

Route::group(['middleware' => ['web','auth:api']], function() {
   Route::get('/products','ProductController@search');
});

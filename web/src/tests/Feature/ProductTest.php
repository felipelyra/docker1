<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ProductTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public $tokenBearer = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImMyMTNmZTBiYzI1NGY4OTI0OTg3NTBhMGRjMmE3NTBkN2ZlZGM4MDBhYmMyNjc5ODRiNGRhOGJkN2NkYWNkMzdhYTg5ODY3NzIwNzgxNzAzIn0.eyJhdWQiOiIxIiwianRpIjoiYzIxM2ZlMGJjMjU0Zjg5MjQ5ODc1MGEwZGMyYTc1MGQ3ZmVkYzgwMGFiYzI2Nzk4NGI0ZGE4YmQ3Y2RhY2QzN2FhODk4Njc3MjA3ODE3MDMiLCJpYXQiOjE1NDc2MTY4ODgsIm5iZiI6MTU0NzYxNjg4OCwiZXhwIjoxNTc5MTUyODg4LCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.kqBdaSSBi6_6-UfyqrhlC-65BPvSJ-JXfpV5q8Unpkc-stAGhy20quT5b9zoixPAk8c0MXZuuyidxEi-txx_11I6EA5k4o-6Jnr1MrHQFdGZkG9kC6vCjKl00XxhpdStPZKZ41atKVpacvtrDPCmT3YDyanyMedPKhNnLW___QGiOiPA7_fhdb5LvC_Zod2qZiePHNdU9gq-jqX626adzIaTPfUx57OT8rXEGMGwIU9p7DrgGYsqi6FrrbVWijCkZ4mM3Lp0q-IWZ-rg10vTOGtCuvMM0LKz24DENtZPyxxMpWcX7lFVueSi6ZxpmtPmJqtdWmGjPtROvqBH4IV4OU1SvsB4UTdi1XnnG84AnZENfcALXFFczsTE-8TN-iGXs8ER-R9NOAAVzLIfrW92MqtxCH4uMjPlqj3fphYkuhb2reHnWMOfUQmpXKfmlWHglvPmo2rlbQmELB4cC_Eg5vJF-Ks2w8mKoPGRz8ST-LFGuEjEZNXB49LpeW9AatGMinY1ipJTwh0ZmOdH7mi9Ef0_eIHMKuqHHp2PMGdOc0sj6CYjSiG61Z0JrmCUHebWhIPWRX7fJTgHNtLIwGSXWgSIufvSORlN_arD7KSkpg8UgofsgWfWtP3exsMugvIUwrw7BYyDylyiOSgBI9qnW-A6bC79WkxqFREZaVz0u6k";

    public function testRequestWithoutParametersUnauthenticated()
    {
        $this->json('GET', 'api/v1/products')
            ->assertStatus(401);
    }

    public function testRequestWithoutParametersAuthenticated()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->tokenBearer,
        ])->json('GET', 'api/v1/products')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [['id', 'title', 'brand', 'price', 'stock']],
                'links' => ['first', 'last', 'prev', 'next'],
                'meta' => ['current_page', 'from', 'last_page', 'path', 'per_page', 'to', 'total']
            ]);
    }

    public function testTestEnv()
    {
        $test = app()->runningUnitTests();
        $this->assertTrue($test);
    }

    public function testPrepareFilterParams()
    {

        // $mockedProductController = Mockery::mock(['prepareFilterParams' => ['title'=>'shoes']]);
        
        // $this->mock = Mockery::mock('Request', 'ProductController');
        // $this->mock->shouldReceive('title:shoes')
        //     ->once()
        //     ->andReturn(['title' => 'shoes']);

        // $this->app->instance('Product', $this->mock);
        //$this->call()


        $product = factory(Product::class)->create();
        // $this->actingAs($product);
        $request = new Request();
        $request->setContainer($this->app);
        $attributes = ['aa' => 'asd'];
        $request->initialize([], $attributes);
        $this->app->instance('request', $request);
        $request->replace($attributes);
        // $authorized = $request->authorize();
        // $this->assertEquals(true, $authorized);

        dump($request);
        // $request = 
        // $product = new Product();

        $result = $product->prepareFilterParams();

    }

}


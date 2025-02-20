<?php

namespace Tests\Feature;

use App\Models\Customer;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{

    use RefreshDatabase;

    public $token = null;

    public function setUp(): void
    {
        parent::setUp();
        
        // seed test user
        $this->seed(UserSeeder::class);
        
        // seed test customer
        $this->seed(CustomerSeeder::class);

        // login
        $response = $this->post('/api/login', [
            'email' => 'test@example.com',
            'password' => 'Password@321',
        ]);

        $this->token = $response->json()['access_token'];
    }

    /**
     * Test customers list
     */
    public function test_customers(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])
        ->get('/api/customers');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'current_page',
                'total_pages',
                'from',
                'to',
            ])
            
            // test default 10 customers per page
            ->assertJsonCount(10, 'data')
            ->assertJson(['from' => 1, 'to' => 10, 'current_page' => 1]);
    }

    /**
     * Test customers list page 2
     */
    public function test_customers_page_2(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])
        ->get('/api/customers?page=2');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'current_page',
                'total_pages',
                'from',
                'to',
            ])
            
            // test default 10 customers per page
            ->assertJsonCount(10, 'data')

            // current page should be 2
            ->assertJson(['from' => 11, 'to' => 20, 'current_page' => 2]);
    }

    /**
     * Test customers list page 9999999, so data should be empty
     */
    public function test_customers_page_9999999_empty_data(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])
        ->get('/api/customers?page=9999999');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'current_page',
                'total_pages',
                'from',
                'to',
            ])
            // test default 10 customers per page
            ->assertJsonCount(0, 'data');
    }

    /**
     * Test customers per page limit 20
     */
    public function test_customers_per_page_limit_20(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])
        ->get('/api/customers?per_page=20');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'current_page',
                'total_pages',
                'from',
                'to',
            ])
            
            // test default 20 customers per page
            ->assertJsonCount(20, 'data')
            ->assertJson(['from' => 1, 'to' => 20, 'current_page' => 1]);
    }

    /**
     * Test customers search
     */
    public function test_customers_search(): void
    {
        // create specific customer
        Customer::factory()->create([
            'first_name' => 'theNameThatCannotBeCreateWithFaker',
            'last_name' => 'Doe',
        ]);

        // do the search
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])
        ->get('/api/customers?search=theNameThatCannotBeCreateWithFaker');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'current_page',
                'total_pages',
                'from',
                'to',
            ])

            // test default 20 customers per page
            ->assertJsonCount(1, 'data');
    }

    /**
     * Test get specific customer and check for ip address data and company details
     */
    public function test_customer_details(): void
    {
        $customer = Customer::inRandomOrder()->first();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])
        ->get('/api/customers/' . $customer->id);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'first_name',
                'last_name',
                'email',
                'gender',
                'ip_addresses',
                'companies',
            ])

            // test default 20 customers per page
            ->assertJsonIsArray('ip_addresses')
            ->assertJsonIsArray('companies');

        // make sure we got the right customer
        $data = $response->json();
        $this->assertEquals($customer->id, $data['id']);
        $this->assertEquals($customer->first_name, $data['first_name']);
        $this->assertEquals($customer->last_name, $data['last_name']);
        $this->assertEquals($customer->email, $data['email']);
        $this->assertEquals($customer->gender, $data['gender']);
        
    }

    /**
     * Test not found customer
     */
    public function test_customer_not_found(): void
    {
        // get last customer
        $customer = Customer::all()->last();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])
        ->get('/api/customers/' . ($customer->id + 1));  // send last customer id + 1

        $response
            ->assertStatus(404)
            ->assertJson(['message' => 'Customer not found']);        
    }
}

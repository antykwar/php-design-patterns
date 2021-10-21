<?php
namespace SpecificationWithDb;

use Illuminate\Database\Capsule\Manager as Database;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

require 'vendor/autoload.php';

interface CustomerSpecification
{
    public function isSatisfiedBy(Customer $customer): bool;

    public function asScope(Builder $query): Builder;
}

class CustomerIsVipClient implements CustomerSpecification
{
    public function isSatisfiedBy(Customer $customer): bool
    {
        return $customer->status === 'vip';
    }

    public function asScope(Builder $query): Builder
    {
        return $query->where('status', 'vip');
    }
}

class Customer extends Model {
    protected $table = 'customers';
    protected $fillable = ['name', 'status'];
}

class CustomerRepository
{
    public function bySpecification(CustomerSpecification $specification): Collection
    {
        $customers = Customer::query();

        $customers = $specification->asScope($customers);

        return $customers->get();
    }

    public function all(): Collection
    {
        return Customer::all();
    }
}

//----------------------

$database = new Database;

$database->addConnection([
    'driver' => 'sqlite',
    'database' => ':memory:'
]);

$database->bootEloquent();
$database->setAsGlobal();

Database::schema()->create('customers', function($table) {
    $table->increments('id');
    $table->string('name');
    $table->string('status');
    $table->timestamps();
});

Customer::create(['name' => 'Name 1', 'status' => 'vip']);
Customer::create(['name' => 'Name 2', 'status' => 'new']);
Customer::create(['name' => 'Name 3', 'status' => 'regular']);
Customer::create(['name' => 'Name 4', 'status' => 'vip']);
Customer::create(['name' => 'Name 5', 'status' => 'privileged']);
Customer::create(['name' => 'Name 6', 'status' => 'regular']);

//----------------------

$customers = new CustomerRepository;

var_dump($customers->all());
var_dump($customers->bySpecification(new CustomerIsVipClient));


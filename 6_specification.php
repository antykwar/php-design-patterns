<?php

interface CustomerSpecification
{
    public function isSatisfiedBy(Customer $customer): bool;
}

class CustomerIsVipClient implements CustomerSpecification
{
    public function isSatisfiedBy(Customer $customer): bool
    {
        return $customer->status() === 'vip';
    }
}

class Customer
{
    public function __construct(protected string $status) {}

    public function status(): string
    {
        return $this->status;
    }
}

class CustomerRepository
{
    public function __construct(protected array $customers = []) {}

    public function bySpecification(CustomerSpecification $specification): array
    {
        $result = [];

        foreach($this->customers as $customer) {
            if ($specification->isSatisfiedBy($customer)) {
                $result[] = $customer;
            }
        }

        return $result;
    }

    public function all(): array
    {
        return $this->customers;
    }
}

$customers = new CustomerRepository([
    new Customer('new'),
    new Customer('vip'),
    new Customer('regular'),
    new Customer('new'),
    new Customer('vip'),
    new Customer('privileged'),
    new Customer('new'),
]);

var_dump($customers->all());
var_dump($customers->bySpecification(new CustomerIsVipClient));

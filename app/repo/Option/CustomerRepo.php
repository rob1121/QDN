<?php

namespace App\repo\Option;
use App\OptionModels\Option;
use JavaScript;

class CustomerRepo {
    public function all() {
        return Option::all();
    }

    public function get($name) {
        return Option::whereCustomer($name)->first();
    }

    public function setup() {
        $customers = $this->all();
        $this->links($customers);
        return $customers;
    }

    public function links($query) {
        JavaScript::put('customers', $query);
        JavaScript::put('links', [
            'removeCustomerOptions' => route('removeCustomerOptions'),
            'updateCustomerOptions' => route('updateCustomerOptions'),
        ]);
    }

    public function store($name) {
        Option::create(['customer' => $name]);
    }

    public function delete($name) {
        Option::whereCustomer($name)->delete();
    }

    public function update($name) {
        $machine = $this->get($name);
        if (!$machine) {
            $this->store($name);
        }
        return $machine ? 'exist' : 'unique';
    }
}
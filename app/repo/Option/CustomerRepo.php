<?php

namespace App\repo\Option;
use App\OptionModels\Option;
use JavaScript;

class CustomerRepo {
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all() {
        return Option::all();
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name) {
        return Option::whereCustomer($name)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function setup() {
        $customers = $this->all();
        $this->links($customers);
        return $customers;
    }

    /**
     * @param $query
     */
    public function links($query) {
        JavaScript::put([
            'customers' => $query,
            'links' => [
                'removeCustomerOptions' => route('removeCustomerOptions'),
                'updateCustomerOptions' => route('updateCustomerOptions'),
            ]
        ]);
    }

    /**
     * @param $name
     */
    public function store($name) {
        Option::create(['customer' => $name]);
    }

    /**
     * @param $name
     */
    public function delete($name) {
        Option::whereCustomer($name)->delete();
    }

    /**
     * @param $name
     * @return string
     */
    public function update($name) {
        $machine = $this->get($name);
        if (!$machine)
            $this->store($name);
            
        return $machine ? 'exist' : 'unique';
    }
}
# web.php
~~~php
Route::get('/customers', 'CustomerController@index');
Route::get('/customers/create', 'CustomerController@create');
Route::post('/customers', 'CustomerController@store');
Route::get('/customers/{customer}', 'CustomerController@show');
Route::get('/customers/{customer}/edit', 'CustomerController@edit');
Route::patch('/customers/{customer}', 'CustomerController@update');
Route::delete('/customers/{customer}', 'CustomerController@destroy');
~~~

# CustomerController.php
~~~php
<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        return view('customer.index', compact('customers'));
    }

    public function create()
    {
        $customer = new Customer();

        return view('customer.create', compact('customer'));
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        $customer = Customer::create($data);

        return redirect('/customers/' . $customer->id);
    }

    public function show(Customer $customer)
    {
        return view('customer.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'));
    }

    public function update(Customer $customer)
    {

        $data = request()->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        $customer->update($data);

        return redirect('/customers');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect('/customers');
    }
}
~~~
# customer/index.blade.php
~~~php
<h1>Customers</h1>

<a href="/customers/create">Add New Customer</a>
@forelse($customers as $customer)
    <p><strong>
            <a href="/customers/{{ $customer->id }}">{{ $customer->name }}</a>
        </strong> ({{ $customer->email }})</p>
@empty
    <p>No customers to show.</p>
@endforelse
~~~
# customer/show.blade.php
~~~php
<h1>Customer Details</h1>

<a href="/customers">< Back</a><br />

<div><strong>Name:</strong> {{ $customer->name }}</div>
<div><strong>Email:</strong> {{ $customer->email }}</div>

<div>
    <a href="/customers/{{ $customer->id }}/edit">Edit</a>

    <form action="/customers/{{ $customer->id }}" method="post">
        @method('DELETE')
        @csrf

        <button>Delete</button>
    </form>

</div>

~~~
# customer/create.blade.php
~~~php
<h1>Add New Customer</h1>

<form action="/customers" method="post">

    @include('customer.form')

    <button>Add New Customer</button>

</form>
~~~
# customer/edit.blade.php
~~~php
<h1>Edit Customer Details</h1>

<form action="/customers/{{ $customer->id }}" method="post">

    @method('PATCH')

    @include('customer.form')

    <button>Update Customer</button>

</form>
~~~
# customer/form.blade.php
~~~php
<div>
    <label for="name">Name</label>
    <input type="text" name="name" value="{{ old('name') ?? $customer->name }}" autocomplete="off">
    @error('name')
    <p style="color: red;">{{ $message }}</p>
    @enderror
</div>
<div>
    <label for="email">Email</label>
    <input type="text" name="email" value="{{ old('email') ?? $customer->email }}" autocomplete="off">
    @error('email')
    <p style="color: red;">{{ $message }}</p>
    @enderror
</div>

@csrf
~~~


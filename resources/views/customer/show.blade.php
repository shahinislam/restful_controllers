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

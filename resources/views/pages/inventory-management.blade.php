@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Inventory Management</h1>

        <!-- Display any success messages -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Display any error messages -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Inventory In Form -->
        <h2>Inventory In</h2>
        <form action="{{ route('inventory.in') }}" method="POST">
            @csrf
            <!-- Add your form fields here -->
        </form>

        <!-- Inventory Out Form -->
        <h2>Inventory Out</h2>
        <form action="{{ route('inventory.out') }}" method="POST">
            @csrf
            <!-- Add your form fields here -->
        </form>

        <!-- Inventory Table -->
        <h2>Current Inventory</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Product</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                @foreach ($inventory as $item)
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td>{{ $item->product }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->price }}</td>
                        <!-- Add more cells as needed -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@extends('books.layout')
@section('page-content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Back to Book List</a>
    </div>
        
    <h1>Details of {{ $book->title }}:</h1>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Title</th>
            <td>{{ $book->title }}</td>
        </tr>
        <tr>
            <th>Author</th>
            <td>{{ $book->author }}</td>
        </tr>
        <tr>
            <th>ISBN</th>
            <td>{{ $book->isbn }}</td>
        </tr>
        <tr>
            <th>Stock</th>
            <td>{{ $book->stock }}</td>
        </tr>
        <tr>
            <th>Price</th>
            <td>${{ number_format($book->price, 2) }}</td>
        </tr>
    </table>
@endsection
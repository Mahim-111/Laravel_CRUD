@extends('books.layout')

@section('page-content')
    <table class="table table-striped table-bordered">
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Stock</th>
            <th>Details</th>
        </tr>
        @foreach($books as $book)
        <tr>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author }}</td>
            <td>{{ $book->stock }}</td>
            <td><a href="{{ route('books.show', $book->id) }}">View</a></td>
        </tr>
        @endforeach
    </table>
    {{ $books->links() }}
@endsection
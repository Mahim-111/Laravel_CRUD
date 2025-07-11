@extends('books.layout')

@section('page-content')
    <p class="text-end">
        <a href="{{ route('books.create') }}" class="btn btn-primary">Add New Book</a>
    </p>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Stock</th>
            <th>Details</th>
            <th>Actions</th>
        </tr>
        @foreach($books as $book)
        <tr>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author }}</td>
            <td>{{ $book->stock }}</td>
            <td>
                <a href="{{ route('books.show', $book->id) }}">View</a>
                
            </td>
            <td>
                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete the book: {{ $book->title }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $books->links() }}
@endsection
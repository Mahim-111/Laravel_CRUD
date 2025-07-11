<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
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
            <td><a href="{{ route('books.show', $book->id) }}">View Details</a></td>
        </tr>
        @endforeach
    </table>
    {{ $books->links() }}

</body>
</html>
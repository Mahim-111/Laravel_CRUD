<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index(){
        //  $books = Book::all(); //for all book        
        // $books = Book::take(10)->get(); //for any 10 book
        // $books = Book::find(1); //for finding a book with it's id
        // dd("$books"); // see the data type of books
        // $books = Book::where('price', '<', 50)->get();//price less than 50
        // $books = Book::whereBetween('price',[20,30])->get(); // price between 20 to 30

        //for long query
        // $books = Book::whereBetween('price',[50,60])
        //             ->where('stock','>', 4)
        //             ->orderBy('title')
        //             // ->get(); // for get the books
        // //             ->tosql();// for see the sql command
        // // return $books;
        $books = Book::paginate(10);
        return view('books.index')->with('books', $books);
    }
    public function show($id){
        $book = Book::findOrFail($id);
        return view('books.show')->with('book', $book);
    }

    public function create(){
        return view('books.create');
    }   

    public function store(Request $request){
        $rules = [
            'title'=> 'required',
            'author'=> 'required',
            'isbn'=> 'required|size:13|unique:books,isbn',
            'stock'=> 'required|numeric|integer|gte:0',
            'price' => 'required|numeric',
        ];
        $message = [
            'stock.gte' => 'Stock must be greater than or equal to 0',
            'isbn.unique' => 'This ISBN is already taken',
        ];
        $request->validate($rules, $message);

        $book = Book::create($request->all());
        return redirect()->route('books.show', $book->id)->with('success', 'Book created successfully!');
    }
   
    public function destroy($id){
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('books.index');
    }
}
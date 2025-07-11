# Laravel CRUD

A simple Laravel application demonstrating basic Create, Read, Update, and Delete (CRUD) operations. This project is designed to help developers learn and implement CRUD functionality using the Laravel PHP framework.

## 🏷️ Tags

![Laravel](https://img.shields.io/badge/Laravel-10.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?style=flat-square&logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple?style=flat-square&logo=bootstrap)

**Keywords:** `Laravel` `PHP` `CRUD` `MySQL` `Bootstrap` `Web Development` `MVC` `Eloquent ORM` `Blade Templates` `Form Validation` `REST API` `Bookstore` `Database Migration` `Factory` `Seeder`

---

## Step-by-Step Instructions

### 1. Create a New Laravel Project

If you haven't already created a Laravel project, run the following command:

```bash
composer create-project laravel/laravel Laravel_CRUD
cd Laravel_CRUD
```

---

### 2. Connect to MySQL Database

-   Copy the example environment file:
    ```bash
    cp .env.example .env
    ```
-   Open `.env` in a text editor and update these lines with your MySQL credentials:
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```
-   Generate an application key:
    ```bash
    php artisan key:generate
    ```
-   Run migrations (after creating your database in MySQL):
    ```bash
    php artisan migrate
    ```

---

### 3. Create Model, Controller, and Factory

To generate a model, controller, and factory, use the following command (replace `Book` with your actual model name):

```bash
php artisan make:model Book -mcf
```

-   `-m` creates a migration file
-   `-c` creates a controller
-   `-f` creates a factory

Edit your migration file in `database/migrations/` to define your table schema, then run:

```bash
php artisan migrate
```

---

### 4. Add Fake Data Using Factory

Open your factory file (for example, `database/factories/BookFactory.php`) and use the following definition:

```php
public function definition(): array
{
    return [
        "title" => fake()->sentence(4),
        "author" => fake()->name,
        "isbn" => fake()->isbn13,
        "stock" => fake()->numberBetween(0, 100),
        "price" => fake()->randomFloat(2, 5, 100),
    ];
}
```

---

### 5. Seeder Section

In your seeder file (for example, `database/seeders/DatabaseSeeder.php`), use the following code to seed the database:

```php
public function run(): void
{
    // User::factory(10)->create();
    Book::truncate();
    User::truncate();
    User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    Book::factory()->count(1000)->create();
}
```

This will:

-   Truncate (clear) the `books` and `users` tables.
-   Create a single user with a specific name and email.
-   Create 1000 fake book records using the factory.

Run the seeder with:

```bash
php artisan db:seed
```

---

### 6. Display Data Using Views

#### List All Books (Index)

-   **Define the Route in `routes/web.php`:**

    ```php
    use App\Http\Controllers\BookController;

    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    ```

-   **Controller Method (`BookController.php`):**

    ```php
    public function index(){
        $books = Book::paginate(10);
        $totalBooks = Book::count();
        return view('books.index', compact('books', 'totalBooks'));
    }
    ```

-   **Blade View Example (`resources/views/books/index.blade.php`):**

    ```blade
    <p>Total Books: {{ $totalBooks }}</p>

    <table border="1" cellpadding="5" cellspacing="0">
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Author</th>
        <th>ISBN</th>
        <th>Stock</th>
        <th>Price</th>
        <th>Action</th>
      </tr>
      @foreach($books as $book)
        <tr>
          <td>{{ $book->id }}</td>
          <td>{{ $book->title }}</td>
          <td>{{ $book->author }}</td>
          <td>{{ $book->isbn }}</td>
          <td>{{ $book->stock }}</td>
          <td>{{ $book->price }}</td>
          <td>
            <a href="{{ route('books.show', $book->id) }}">Show</a>
          </td>
        </tr>
      @endforeach
    </table>

    <!-- Pagination links -->
    {{ $books->links() }}
    ```

---

#### Show a Single Book (Show)

-   **Add Route in `routes/web.php`:**

    ```php
    Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
    ```

-   **Controller Method (`BookController.php`):**

    ```php
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('books.show', compact('book'));
    }
    ```

-   **Blade View Example (`resources/views/books/show.blade.php`):**
    ```blade
    <h2>Book Details</h2>
    <ul>
        <li><strong>ID:</strong> {{ $book->id }}</li>
        <li><strong>Title:</strong> {{ $book->title }}</li>
        <li><strong>Author:</strong> {{ $book->author }}</li>
        <li><strong>ISBN:</strong> {{ $book->isbn }}</li>
        <li><strong>Stock:</strong> {{ $book->stock }}</li>
        <li><strong>Price:</strong> {{ $book->price }}</li>
    </ul>
    <a href="{{ route('books.index') }}">Back to List</a>
    ```

---

#### Create a New Book (Create)

-   **Add Routes in `routes/web.php`:**

    ```php
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    ```

-   **Controller Methods:**

    -   `create()` - Display the create form
    -   `store(Request $request)` - Validate and save new book data

-   **Model Configuration:**

    -   Add fillable properties: `title`, `author`, `stock`, `isbn`, `price`

-   **Create Form Features:**

    -   Bootstrap styling with responsive design
    -   Form validation with custom error messages
    -   CSRF protection for security
    -   ISBN validation (13 characters required)
    -   Stock validation (non-negative integer)
    -   Price validation (decimal values accepted)
    -   Redirects to book details page after creation

-   **Validation Rules:**
    -   Title & Author: Required
    -   ISBN: Required, exactly 13 characters, unique
    -   Stock: Required, numeric, non-negative
    -   Price: Required, numeric

---

#### Edit a Book (Update)

-   **Add Routes in `routes/web.php`:**

    ```php
    Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{id}', [BookController::class, 'update'])->name('books.update');
    ```

-   **Controller Methods:**

    -   `edit($id)` - Display the edit form with pre-populated data
    -   `update(Request $request, $id)` - Validate and update book data

-   **Edit Form Features:**

    -   Bootstrap styling with responsive design
    -   Pre-populated form fields with existing book data
    -   Form validation with custom error messages
    -   CSRF protection and PUT method for security
    -   ISBN uniqueness validation (excluding current book)
    -   Stock and price validation
    -   Cancel and Update buttons for user convenience

-   **Validation Rules:**
    -   Title & Author: Required
    -   ISBN: Required, exactly 13 characters, unique (excluding current book)
    -   Stock: Required, numeric, non-negative
    -   Price: Required, numeric

---

#### Delete a Book (Destroy)

-   **Add Route in `routes/web.php`:**

    ```php
    Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');
    ```

-   **Controller Method:**

    -   `destroy($id)` - Find and delete the book, redirect to index

-   **Delete Features:**

    -   JavaScript confirmation dialog before deletion
    -   Displays book title in confirmation message
    -   DELETE method for proper REST convention
    -   CSRF protection for security
    -   Redirects to book list after deletion
    -   Available on both index and show pages

-   **User Experience:**
    -   Confirmation message: "Are you sure you want to delete the book: [Book Title]?"
    -   Prevents accidental deletions
    -   Clear feedback on which book will be deleted

---

## Full Installation & Usage

1. **Clone the repository**

    ```bash
    git clone https://github.com/Mahim-111/Laravel_CRUD.git
    cd Laravel_CRUD
    ```

2. **Install dependencies**

    ```bash
    composer install
    ```

3. **Complete steps 2–6 above**

4. **Start the development server**
    ```bash
    php artisan serve
    ```
    Then visit [http://localhost:8000/books](http://localhost:8000/books) in your browser.

---

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request.

---

## 👨‍💻 Author

**Md. Mahim Babu**  
Dept. of Computer Science and Engineering  
University of Rajshahi  
📧 mahimbabu111111@gmail.com  
📱 01799884594

---

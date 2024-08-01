<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Page;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function store(Request $request)
    {
        // Get the authenticated user
        $user = auth()->user();
        $data = $request->all();

        // Validate the request data
        //check book name
        if (!isset($data['book_name']) || empty($data['book_name'])) {
            return response()->json(['result' => 'fail', 'message' => 'book name is required.','response_code' => '201'], 422);
        } elseif (!is_string($data['book_name'])) {
            return response()->json(['result' => 'fail', 'message' => 'book name formatting error.','response_code' => '201'], 422);
        }  
        //auther name
        if (!isset($data['author_name']) || empty($data['author_name'])) {
            return response()->json(['result' => 'fail', 'message' => 'author name is required.','response_code' => '201'], 422);
        } elseif (!is_string($data['author_name'])) {
            return response()->json(['result' => 'fail', 'message' => 'author name formatting error.','response_code' => '201'], 422);
        }

        //book_type
        if (!isset($data['book_type']) || empty($data['book_type'])) {
            return response()->json(['result' => 'fail', 'message' => 'book type is required.','response_code' => '201'], 422);
        } elseif (!is_string($data['book_type'])) {
            return response()->json(['result' => 'fail', 'message' => 'book type formatting error.','response_code' => '201'], 422);
        }

        //book_category
        if (!isset($data['book_category']) || empty($data['book_category'])) {
            return response()->json(['result' => 'fail', 'message' => 'book category is required.','response_code' => '201'], 422);
        } elseif (!is_string($data['book_category'])) {
            return response()->json(['result' => 'fail', 'message' => 'book category formatting error.','response_code' => '201'], 422);
        }

        //conclusion
        if (!isset($data['conclusion']) || empty($data['conclusion'])) {
            return response()->json(['result' => 'fail', 'message' => 'book conclusion is required.','response_code' => '201'], 422);
        } elseif (!is_string($data['conclusion'])) {
            return response()->json(['result' => 'fail', 'message' => 'book conclusion formatting error.','response_code' => '201'], 422);
        }

          //book_title
        if (!isset($data['book_title']) || empty($data['book_title'])) {
            return response()->json(['result' => 'fail', 'message' => 'book title is required.','response_code' => '201'], 422);
        } elseif (!is_string($data['book_title'])) {
            return response()->json(['result' => 'fail', 'message' => 'book title formatting error.','response_code' => '201'], 422);
        }

        $bookCount = Book::where('user_id', $user->id)->count();
        if ($bookCount >= 5) {
            // return response()->json(['error' => 'You can only create a maximum of 5 books'], 403);
            return response()->json(['result' => 'error', 'message' => 'You can only create a maximum of 5 books','response_code' => '200'], 200);

        }

        // Check if the user already has 3 pending books
        $pendingBookCount = Book::where('user_id', $user->id)
                                ->where('status', 'pending')
                                ->count();
        if ($pendingBookCount >= 3) {
            return response()->json(['result' => 'error', 'message' => 'You can only have a maximum of 3 pending books','response_code' => '200'], 200);

            // return response()->json(['error' => 'You can only have a maximum of 3 pending books'], 403);
        }

        // Check if the user already has a pending book with the same name
        $existingBook = Book::where('user_id', $user->id)
                            ->where('status', 'pending' && 'status', 'complete')
                            ->where('book_name', $request->book_name)
                            ->first();

        if ($existingBook) {
        // Update the existing pending book
        $existingBook->update([
        'book_name' => $request->book_name,
        'author_name' => $request->author_name,
        'email' => $request->email,
        'book_type' => $request->book_type,
        'book_category' => $request->book_category,
        'conclusion' => $request->conclusion,
        'cover_picture' => $request->cover_picture,
        'finish_date' => $request->finish_date,
        'modify_date' => $request->modify_date,
        'book_title' => $request->book_title,
        'status' => $request->status,
        ]);

        foreach ($request->pages as $page) {
            $existingPage = Page::where('book_id', $existingBook->id)
                                ->where('page_no', $page['page_no'])
                                ->first();
    
            if ($existingPage) {
                // Update existing page
                $existingPage->update([
                    'page_subtitle' => $page['page_subtitle'],
                    'page_details' => $page['page_details']
                ]);
            } else {
                // Create new page if it doesn't exist
                Page::create([
                    'book_id' => $existingBook->id,
                    'page_no' => $page['page_no'],
                    'page_subtitle' => $page['page_subtitle'],
                    'page_details' => $page['page_details']
                ]);
            }
        }
        
        $message = ($request->status == 'pending') ? 'Book updated successfully' : 'Book complete success';

        return response()->json(['result' => 'success', 'message' => $message, 'response_code' => '200'], 200);
        
    } else{
        // Create the new book
        $existingBookCheck = Book::where('user_id', $user->id)
        ->where('status', 'complete')
        ->where('book_name', $request->book_name)
        ->first();
        if ($existingBookCheck) {
            return response()->json(['result' => 'success', 'message' => 'This Book Name Already Used','response_code' => '200'], 200);
        }
        $book = Book::create([
            'user_id' => $user->id,
            'book_name' => $request->book_name,
            'author_name' => $request->author_name,
            'email' => $request->email,
            'book_type' => $request->book_type,
            'book_category' => $request->book_category,  
            'conclusion' => $request->conclusion,
            'cover_picture' => $request->cover_picture,
            'finish_date' => $request->finish_date,
            'modify_date' => $request->modify_date,
            'book_title' => $request->book_title,
            'status' => $request->status,
        ]);
    }

        // Add the pages
        foreach ($request->pages as $page) {
            Page::create([
                'book_id' => $book->id,
                'page_no' => $page['page_no'],
                'page_subtitle' => $page['page_subtitle'],
                'page_details' => $page['page_details']
            ]);
        }

        // return response()->json($book, 201);
        return response()->json(['result' => 'success', 'message' => 'New Book create success','response_code' => '200'], 200);

    }

    public function updateBook(Request $request, Book $book)
    {
        $this->authorize('update', $book);

        $book->update($request->only(['book_name',
                                    'author_name',
                                    'email',
                                    'book_type',
                                    'book_category',
                                    'conclusion',
                                    'cover_picture',
                                    'finish_date',
                                    'modify_date',
                                    'book_title',
                                    'status']));

        $book->pages()->delete(); // Remove old pages
        foreach ($request->pages as $page) {
            $book->pages()->create($page);
        }

        // return response()->json($book->load('pages'));
        return response()->json(['result' => 'success', 'message' => 'Book Delete success','response_code' => '200'], 200);

    }

    public function destroy(Book $book)
    {
        $this->authorize('delete', $book);

        $book->delete();

        return response()->json(null, 204);
    }

    public function getPendingBooks()
    {
        // Get the authenticated user
        $user = auth()->user();

        $pendingBooks = Book::where('user_id', $user->id)
                            ->where('status', 'pending')
                            ->with('pages')
                            ->get();
        return response()->json(['result' => 'success', 'message' => $pendingBooks,'response_code' => '200'], 200);

        // return response()->json($pendingBooks, 200); 
    }

    public function getCompleteBook()
    {
        // Get the authenticated user
        $user = auth()->user();

        $completeBook = Book::where('user_id', $user->id)
                            ->where('status', 'complete')
                            ->with('pages')
                            ->get();
        return response()->json(['result' => 'success', 'message' => $completeBook,'response_code' => '200'], 200);
    }

    //get selected book Data
    public function getSelectedBook(Request $request)
    {
        // Get the authenticated user
        // $user = auth()->user();
        $bookdata = $request->all();

        // Validate the request data
        //check book name
        if (!isset($bookdata['book_name']) || empty($bookdata['book_name'])) {
            return response()->json(['result' => 'fail', 'message' => 'Invalide Book Selection','response_code' => '201'], 422);
        }
        $selectedBookData = Book::
        // where('user_id', $user->id)
                            where('book_name', $request->book_name)
                            ->with('pages')
                            ->get();
        return response()->json(['result' => 'success', 'message' => $selectedBookData,'response_code' => '200'], 200);
    }
    
}

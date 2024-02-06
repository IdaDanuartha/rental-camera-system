<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use App\Utils\ResponseMessage;
use Illuminate\Http\Request;

class BookingCameraController extends Controller
{
    public function __construct(
        protected readonly ProductRepository $product,
        protected readonly ResponseMessage $responseMessage
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->product->findAllPaginate(12);
        return view("dashboard.bookings.book-camera", compact("products"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

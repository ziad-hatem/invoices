<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachment;
use App\Models\invoices;
use App\Models\invoices_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceAchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = invoices::onlyTrashed()->get();
        return view('Invoices.Archive_Invoices', ['invoices' => $invoices]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices = invoices::withTrashed()->where('id', $id)->first();
        $details  = invoices_details::where('id_Invoice', $id)->get();
        $attachments  = invoice_attachment::where('invoice_id', $id)->get();
        return view('invoices.details_invoice', ['attachments' => $attachments, 'details' => $details, 'invoices' => $invoices, 'archived' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->invoice_id;
        $flight = Invoices::withTrashed()->where('id', $id)->restore();
        session()->flash('restore_invoice');
        return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = invoices::withTrashed()->where('id', $request->invoice_id)->first();
        $details = invoice_attachment::where('invoice_id', $id)->first();

        if (Storage::disk('public_uploads')->exists($invoices->invoice_number)) {
            Storage::disk('public_uploads')->deleteDirectory($invoices->invoice_number);
        }
        $invoices->forceDelete();
        $details->forceDelete();
        session()->flash('delete_invoice');
        return redirect('/Archive');
    }
}

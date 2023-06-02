<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Status;
use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;

class StatusesController extends Controller
{
    function index(Status $status)
    {
        $statuses = Status::latest()->paginate(6);
        return view('statuses.index', ['statuses' => $statuses, 'status' => $status]);
    }

    function create(Status $status)
    {
        $this->authorize('create', $status);
        return view('statuses.create');
    }

    function store(StoreStatusRequest $request, Status $status)
    {
        $this->authorize('create', $status);
        $status = new Status;
        $status->name = $request->name;
        $status->save();
        return redirect('statuses')->with('message', 'Status succesvol gecreëerd');
    }
    
    function edit(Status $status)
    {
        $this->authorize('update', $status);
        return view('statuses.edit', ['status' => $status]);
    }

    function update(UpdateStatusRequest $request, Status $status)
    {
        $this->authorize('update', $status);
        $status->name = $request->name;
        $status->update();
        return back()->with('message', 'Status succesvol bewerkt.');
    }

    function destroy(Request $request, Status $status)
    {
        $this->authorize('delete', $status);
        $status->delete();
        return back()->with('message', 'Status succesvol verwijderd.');
    }

    function adminIndex(Status $status)
    {
        $this->authorize('adminView', $status);

        $statuses = Status::latest()->paginate(6);
        return view('admin.statuses.index', ['statuses' => $statuses]);
    }

    function adminCreate(Status $status)
    {
        $this->authorize('create', $status);
        return view('admin.statuses.create');
    }

    function adminStore(StoreStatusRequest $request, Status $status)
    {
        $this->authorize('create', $status);
        $status = new Status;
        $status->name = $request->name;
        $status->save();
        return redirect('admin/statuses')->with('message', 'Status succesvol gecreëerd');
    }
    
    function adminEdit(Status $status)
    {
        $this->authorize('update', $status);
        return view('admin.statuses.edit', ['status' => $status]);
    }

    function adminUpdate(UpdateStatusRequest $request, Status $status)
    {
        $this->authorize('update', $status);
        $status->name = $request->name;
        $status->update();
        return redirect('/admin/statuses')->with('message', 'Status succesvol bewerkt.');
    }

    function adminDestroy(Request $request, Status $status)
    {
        $this->authorize('delete', $status);
        $status->delete();
        return back()->with('message', 'Status succesvol verwijderd.');
    }

    
    public function searchIndex(Status $status, Request $request)
    {
        $this->authorize('view', $status);

        $statuses = Status::where('name', 'like', '%' . $request->search_term.'%')
        ->latest()->paginate(6);

        return view('admin.statuses.index', ['statuses' => $statuses, 'search_term' => $request->search_term]);
    }
}

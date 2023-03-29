<?php

namespace App\Http\Controllers\Backend\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Pages\CreatePageRequest;
use App\Http\Requests\Backend\Pages\DeletePageRequest;
use App\Http\Requests\Backend\Pages\EditPageRequest;
use App\Http\Requests\Backend\Pages\ManagePageRequest;
use App\Http\Requests\Backend\Pages\StorePageRequest;
use App\Http\Requests\Backend\Pages\UpdatePageRequest;
use App\Http\Responses\Backend\Page\EditResponse;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Models\Page;
use App\Repositories\Backend\PagesRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use DB;
use Validator,Redirect,Response,File;
use App\Document;
class PagesController extends Controller
{
    /**
     * @var \App\Repositories\Backend\PagesRepository
     */
    protected $repository;

    /**
     * @param \App\Repositories\Backend\PagesRepository $repository
     */
    public function __construct(PagesRepository $repository)
    {
        $this->repository = $repository;
        View::share('js', ['pages']);
    }

    /**
     * @param \App\Http\Requests\Backend\Pages\ManagePageRequest $request
     *
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManagePageRequest $request)
    {
        return new ViewResponse('backend.pages.index');
    }

    /**
     * @param \App\Http\Requests\Backend\Pages\CreatePageRequest $request
     *
     * @return \App\Http\Responses\ViewResponse
     */
    public function create(CreatePageRequest $request)
    {
        return new ViewResponse('backend.pages.create');
    }

    /**
     * @param \App\Http\Requests\Backend\Pages\StorePageRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StorePageRequest $request)
    {
        $this->repository->create($request->except(['_token', '_method']));

        return new RedirectResponse(route('admin.pages.index'), ['flash_success' => __('alerts.backend.pages.created')]);
    }

    /**
     * @param \App\Models\Page $page
     * @param \App\Http\Requests\Backend\Pages\EditPageRequest $request
     *
     * @return \App\Http\Responses\Backend\Blog\EditResponse
     */
    public function edit(Page $page, EditPageRequest $request)
    {
        return new EditResponse($page);
    }

    /**
     * @param \App\Models\Page $page
     * @param \App\Http\Requests\Backend\Pages\UpdatePageRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function update(Page $page, UpdatePageRequest $request)
    {
        $this->repository->update($page, $request->except(['_token', '_method']));

        return new RedirectResponse(route('admin.pages.index'), ['flash_success' => __('alerts.backend.pages.updated')]);
    }

    /**
     * @param \App\Models\Page $page
     * @param \App\Http\Requests\Backend\Pages\DeletePageRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function destroy(Page $page, DeletePageRequest $request)
    {
        $this->repository->delete($page);

        return new RedirectResponse(route('admin.pages.index'), ['flash_success' => __('alerts.backend.pages.deleted')]);
    }

    public function store_data(Request $request)
    {
        request()->validate([
            'file'  => 'required|mimes:doc,docx,pdf,txt|max:2048',
          ]);
          $files = $request->file('file');
        //   var_dump($files)
           if ($files) {
                
               //store file into document folder
               $file = $request->file->store('public/documents');
    
               //store your file into database
                $query = DB::insert("insert into pages (upload_file,created_by) values(?,now())",[$file]);

               return Response()->json([
                   "success" => true,
                   "file" => $file
               ]);
     
           }

        return Response()->json([
            "success" => false,
            "file" => ''
        ]);
    }
    
}

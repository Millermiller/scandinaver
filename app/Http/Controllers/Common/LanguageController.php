<?php


namespace App\Http\Controllers\Common;


use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Scandinaver\Common\Domain\Permission\Language;
use Scandinaver\Common\UI\Command\CreateLanguageCommand;
use Scandinaver\Common\UI\Command\DeleteLanguageCommand;
use Scandinaver\Common\UI\Command\UpdateLanguageCommand;
use Scandinaver\Common\UI\Query\LanguagesQuery;

/**
 * Class LanguageController
 *
 * @package App\Http\Controllers\Common
 */
class LanguageController extends Controller
{

    /**
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(): JsonResponse
    {
        Gate::authorize(Language::VIEW);

        return $this->execute(new LanguagesQuery());
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(Request $request): JsonResponse
    {
        Gate::authorize(Language::CREATE);

        $data = $request->toArray();
        $data['flag'] = $request->file('file');

        return $this->execute(new CreateLanguageCommand($data), JsonResponse::HTTP_CREATED);
    }

    /**
     * @param  Request  $request
     * @param  int      $id
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        Gate::authorize(Language::UPDATE, $id);

        $data = $request->toArray();
        $data['flag'] = $request->file('file');

        return $this->execute(new UpdateLanguageCommand($id, $data));
    }

    /**
     * @param  int  $id
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(int $id): JsonResponse
    {
        Gate::authorize(Language::DELETE, $id);

        $this->execute(new DeleteLanguageCommand($id), JsonResponse::HTTP_NO_CONTENT);

        return response()->json(NULL, 204);
    }
}
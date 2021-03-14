<?php


namespace App\Http\Controllers\Learn;

use App\Helpers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAssetRequest;
use App\Http\Requests\PersonalRequest;
use App\Http\Requests\UpdateAssetRequest;
use Exception;
use Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\{JsonResponse, Request};
use Scandinaver\Learn\Domain\Model\Asset;
use Scandinaver\Learn\Domain\Permissions\Card;
use Scandinaver\Learn\UI\Command\AddBasicLevelCommand;
use Scandinaver\Learn\UI\Command\AddCardToAssetCommand;
use Scandinaver\Learn\UI\Command\AddWordAndTranslateCommand;
use Scandinaver\Learn\UI\Command\CreateAssetCommand;
use Scandinaver\Learn\UI\Command\CreateTranslateCommand;
use Scandinaver\Learn\UI\Command\DeleteAssetCommand;
use Scandinaver\Learn\UI\Command\DeleteCardFromAssetCommand;
use Scandinaver\Learn\UI\Command\EditTranslateCommand;
use Scandinaver\Learn\UI\Command\SetTranslateForCardCommand;
use Scandinaver\Learn\UI\Command\UpdateAssetCommand;
use Scandinaver\Learn\UI\Command\UploadAudioCommand;
use Scandinaver\Learn\UI\Query\AssetForUserByTypeQuery;
use Scandinaver\Learn\UI\Query\AssetsQuery;
use Scandinaver\Learn\UI\Query\CardsOfAssetQuery;
use Scandinaver\Learn\UI\Query\FindAudioQuery;
use Scandinaver\Learn\UI\Query\GetAssetsByTypeQuery;
use Scandinaver\Learn\UI\Query\GetExamplesForCardQuery;
use Scandinaver\Learn\UI\Query\GetTranslatesByWordQuery;
use Scandinaver\Learn\UI\Query\GetUnusedSentencesQuery;
use Scandinaver\Learn\UI\Query\PersonalAssetsQuery;
use Scandinaver\Shared\EventBusNotFoundException;
use Scandinaver\User\Domain\Model\User;

/**
 * Class AssetController
 *
 * @package App\Http\Controllers\Learn
 */
class AssetController extends Controller
{

    /**
     * @param  string  $languageId
     *
     * @return JsonResponse
     * @throws AuthorizationException|BindingResolutionException
     */
    public function index(string $languageId): JsonResponse
    {
        Gate::authorize(\Scandinaver\Learn\Domain\Permissions\Asset::VIEW);

        return response()->json([
                                    'words'     => $this->queryBus->execute(new GetAssetsByTypeQuery($languageId, Asset::TYPE_WORDS)),
                                    'sentences' => $this->queryBus->execute(new GetAssetsByTypeQuery($languageId, Asset::TYPE_SENTENCES)),
                                ]);
    }

    /**
     * @param  int     $id
     *
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws EventBusNotFoundException
     */
    public function show(int $id): JsonResponse
    {
        Gate::authorize(\Scandinaver\Learn\Domain\Permissions\Asset::SHOW, $id);

        return $this->execute(new CardsOfAssetQuery(Auth::user(), $id));
    }

    /**
     * @param  CreateAssetRequest  $request
     *
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws EventBusNotFoundException
     */
    public function store(CreateAssetRequest $request): JsonResponse
    {
        Gate::authorize(\Scandinaver\Learn\Domain\Permissions\Asset::CREATE);

        $data = $request->toArray();

        return $this->execute(new CreateAssetCommand(Auth::user(), $data), JsonResponse::HTTP_CREATED);
    }

    /**
     * @param  int      $id
     * @param  UpdateAssetRequest  $request
     *
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws EventBusNotFoundException
     */
    public function update(int $id, UpdateAssetRequest $request): JsonResponse
    {
        Gate::authorize(\Scandinaver\Learn\Domain\Permissions\Asset::UPDATE, $id);

        return $this->execute(new UpdateAssetCommand(Auth::user(), $id, $request->toArray()));
    }

    /**
     * @param  int  $id
     *
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws EventBusNotFoundException
     */
    public function destroy(int $id): JsonResponse
    {
        Gate::authorize(\Scandinaver\Learn\Domain\Permissions\Asset::DELETE, $id);

        return $this->execute(new DeleteAssetCommand($id), JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * @param  string  $languageId
     *
     * @return JsonResponse
     * @throws EventBusNotFoundException
     */
    public function getWords(string $languageId): JsonResponse
    {
        return $this->execute(new AssetForUserByTypeQuery($languageId, Auth::user(), Asset::TYPE_WORDS));
    }

    /**
     * @param  string  $languageId
     *
     * @return JsonResponse
     * @throws EventBusNotFoundException
     */
    public function getSentences(string $languageId): JsonResponse
    {
        return $this->execute(new AssetForUserByTypeQuery($languageId, Auth::user(), Asset::TYPE_SENTENCES));
    }

    /**
     * @param  string  $languageId
     *
     * @return JsonResponse
     * @throws EventBusNotFoundException
     */
    public function getAllSentences(string $languageId): JsonResponse
    {
        return $this->execute(new GetUnusedSentencesQuery($languageId));
    }

    /**
     * @param  PersonalRequest  $request
     *
     * @return JsonResponse
     * @throws EventBusNotFoundException
     */
    public function getPersonal(PersonalRequest $request): JsonResponse
    {
        $language = $request->get('lang');

        return $this->execute(new PersonalAssetsQuery(Auth::user(), $language));
    }

    /**
     * @param  int  $wordId
     *
     * @return JsonResponse
     * @throws EventBusNotFoundException
     */
    public function findAudio(int $wordId): JsonResponse
    {
        return $this->execute(new FindAudioQuery($wordId));
    }

    /**
     * @param  int  $assetId
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function showAsset(int $assetId): JsonResponse
    {
        Gate::authorize(\Scandinaver\Learn\Domain\Permissions\Asset::SHOW, $assetId);

        return response()->json($assetId);
    }

    /**
     * @param  string  $languageId
     * @param  int     $wordId
     *
     * @return JsonResponse
     * @throws EventBusNotFoundException
     */
    public function showValues(string $languageId, int $wordId): JsonResponse
    {
        return $this->execute(new GetTranslatesByWordQuery($wordId));
    }

    /**
     * @param  string  $languageId
     * @param  int     $cardId
     *
     * @return JsonResponse
     * @throws EventBusNotFoundException
     */
    public function showExamples(string $languageId, int $cardId): JsonResponse
    {
        return $this->execute(new GetExamplesForCardQuery($cardId));
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     * @throws EventBusNotFoundException
     * @throws BindingResolutionException
     */
    public function changeUsedTranslate(Request $request): JsonResponse
    {
        return $this->execute(new SetTranslateForCardCommand($request->toArray()));
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     * @throws EventBusNotFoundException
     */
    public function editTranslate(Request $request): JsonResponse
    {
        $this->execute(new EditTranslateCommand($request->toArray()));

        if ($request->get('examples')) {
            foreach ($request->get('examples') as $example) {
                $this->execute(new CreateTranslateCommand($request->get('card_id'), $example));
            }
        }

        return response()->json(NULL, 200);
    }

    /**
     * @param  Request  $request
     * @param  int      $wordId
     *
     * @return JsonResponse
     * @throws EventBusNotFoundException
     */
    public function uploadAudio(Request $request, int $wordId): JsonResponse
    {
        return $this->execute(new UploadAudioCommand($wordId, $request->file('audiofile')), JsonResponse::HTTP_CREATED);
    }

    /**
     * @param  string   $languageId
     * @param  Request  $request
     *
     * @return JsonResponse
     * @throws EventBusNotFoundException
     */
    public function addBasicAssetLevel(string $languageId, Request $request): JsonResponse
    {
        return $this->execute(new AddBasicLevelCommand($languageId, $request->toArray()), JsonResponse::HTTP_CREATED);
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     * @throws EventBusNotFoundException
     */
    public function addPair(Request $request): JsonResponse
    {
        return $this->execute(new AddWordAndTranslateCommand($request->toArray()), JsonResponse::HTTP_CREATED);
    }

    /**
     * @param  int      $assetId
     * @param  Request  $request
     *
     * @return JsonResponse
     * @throws EventBusNotFoundException
     */
    public function changeAsset(int $assetId, Request $request): JsonResponse
    {
        return $this->execute(new UpdateAssetCommand(Auth::user(), $assetId, $request->toArray()));
    }

    /**
     * @param  int  $asset
     * @param  int  $card
     *
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws EventBusNotFoundException
     */
    public function addCard(int $asset, int $card): JsonResponse
    {
        Gate::authorize(\Scandinaver\Learn\Domain\Permissions\Asset::ADD_CARD);

        return $this->execute(new AddCardToAssetCommand(Auth::user(), $asset, $card), JsonResponse::HTTP_CREATED);
    }

    /**
     * @param  int  $asset
     * @param  int  $card
     *
     * @return JsonResponse
     * @throws AuthorizationException|EventBusNotFoundException
     */
    public function removeCard(int $asset, int $card): JsonResponse
    {
        Gate::authorize(Card::DELETE, [$card, $asset]);

        return $this->execute(new DeleteCardFromAssetCommand(Auth::user(), $asset, $card), JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * @param  string  $languageId
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function assetsMobile(string $languageId): JsonResponse
    {
        // $validator = Validator::make(
        //     ['language' => $language],
        //     [
        //         'language' => 'exists:Scandinaver\Common\Domain\Model\Language,name'
        //     ],
        //     [
        //         'exists' => 'Неверный параметр'
        //     ]
        // );
        //
        // if ($validator->fails()) {
        //     return response()->json([$validator->errors()], 400);
        // }

        /** @var User $user */
        $user = auth('api')->user();

        return $this->execute(new AssetsQuery($user, $languageId));
    }
}
<?php


namespace Scandinaver\User\Domain\Services;

use Auth;
use Scandinaver\Common\Domain\Contract\Repository\LanguageRepositoryInterface;
use Scandinaver\Common\Domain\Services\IntroService;
use Scandinaver\Common\Domain\Services\LanguageTrait;
use Scandinaver\Learn\Domain\Contract\Repository\AssetRepositoryInterface;
use Scandinaver\Learn\Domain\Contract\Repository\FavouriteAssetRepositoryInterface;
use Scandinaver\Learn\Domain\Contract\Repository\PersonalAssetRepositoryInterface;
use Scandinaver\Learn\Domain\Model\FavouriteAsset;
use Scandinaver\Translate\Domain\Contract\Repository\TextRepositoryInterface;
use Scandinaver\User\Domain\Contract\Repository\PlanRepositoryInterface;
use Scandinaver\User\Domain\Contract\Repository\UserRepositoryInterface;
use Scandinaver\User\Domain\Model\User;
use App\Events\{UserDeleted, UserRegistered};
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Scandinaver\Common\Domain\Model\Language;
use Scandinaver\Learn\Domain\Model\Asset;
use Scandinaver\Learn\Domain\Services\AssetService;
use Scandinaver\Puzzle\Domain\PuzzleService;
use Scandinaver\Translate\Domain\TextService;
use Scandinaver\User\Domain\Exceptions\UserNotFoundException;

/**
 * Class UserService
 * todo: refactor
 *
 * @package Scandinaver\User\Domain\Services
 */
class UserService
{
    use LanguageTrait;

    protected AssetService $assetService;

    protected UserRepositoryInterface $userRepository;

    protected PlanRepositoryInterface $planRepository;

    protected LanguageRepositoryInterface $languageRepository;

    protected AssetRepositoryInterface $assetRepository;

    protected FavouriteAssetRepositoryInterface $favouriteAssetRepository;

    protected PersonalAssetRepositoryInterface $personalAssetRepository;

    protected TextRepositoryInterface $textRepository;

    private TextService $textService;

    private PuzzleService $puzzleService;

    private IntroService $introService;

    public function __construct(
        AssetRepositoryInterface $assetRepository,
        FavouriteAssetRepositoryInterface $favouriteAssetRepository,
        PersonalAssetRepositoryInterface $personalAssetRepository,
        AssetService $assetService,
        UserRepositoryInterface $userRepository,
        PlanRepositoryInterface $planRepository,
        LanguageRepositoryInterface $languageRepository,
        TextRepositoryInterface $textRepository,
        TextService $textService,
        PuzzleService $puzzleService,
        IntroService $introService
    ) {
        $this->userRepository = $userRepository;
        $this->planRepository = $planRepository;
        $this->languageRepository = $languageRepository;
        $this->assetRepository = $assetRepository;
        $this->textRepository = $textRepository;
        $this->assetService = $assetService;
        $this->textService = $textService;
        $this->puzzleService = $puzzleService;
        $this->favouriteAssetRepository = $favouriteAssetRepository;
        $this->personalAssetRepository = $personalAssetRepository;
        $this->introService = $introService;
    }

    public function getAll(): array
    {
        return $this->userRepository->all();
    }

    public function find($string): array
    {
        return $this->userRepository->findByNameOrEmail($string);
    }

    /**
     * @throws UserNotFoundException
     * @throws Exception
     */
    public function login(array $credentials): ?User
    {
        if (!Auth::attempt($credentials)) {
            throw new UserNotFoundException();
        }

        return \App\Helpers\Auth::user();
    }

    public function registration(array $data): User
    {
        $plan = $this->planRepository->get(1);

        /** @var Language[] $languages */
        $languages = $this->languageRepository->all();

        $user = new User();
        $user->setAssets(new ArrayCollection());
        $user->setTexts(new ArrayCollection());
        $user->setLogin($data['login']);
        $user->setEmail($data['email']);
        $user->setPassword(bcrypt($data['password']));
        $user->setPlan($plan);
        $user->setCreatedAt(Carbon::now()->format("Y-m-d H:i:s"));
        $user = $this->userRepository->save($user);

        foreach ($languages as $language) {
            //даем пользователю избранное
            $favourite = new FavouriteAsset(
                'Избранное',
                false,
                Asset::TYPE_FAVORITES,
                1,
                $language
            );
            $favourite = $this->assetRepository->save($favourite);
            $this->userRepository->addAsset($user, $favourite);

            //даем пользователю первый словарь слов
            $firstWordAsset = $this->assetRepository->getFirstAsset(
                $language,
                Asset::TYPE_WORDS
            );
            $this->userRepository->addAsset($user, $firstWordAsset);

            //даем пользователю первый словарь предложений
            $firstSentencesAsset = $this->assetRepository->getFirstAsset(
                $language,
                Asset::TYPE_SENTENCES
            );
            $this->userRepository->addAsset($user, $firstSentencesAsset);

            //даем пользователю первый текст
            $firstText = $this->textRepository->getFirstText($language);
            $this->userRepository->addText($user, $firstText);
        }

        event(new UserRegistered($user, $data));

        return $user;
    }

    public function getState(User $user, string $language): array
    {
       $language = $this->getLanguage($language);

        return [
            'site' => config('app.MAIN_SITE'),
            'words' => $this->assetService->getAssetsByType(
                $language->getName(),
                $user,
                Asset::TYPE_WORDS
            ),
            'sentences' => $this->assetService->getAssetsByType(
                $language->getName(),
                $user,
                Asset::TYPE_SENTENCES
            ),
            'favourites' => $this->favouriteAssetRepository->getFavouriteAsset(
                $language,
                $user
            ),
            'personal' => $this->personalAssetRepository->getCreatedAssets(
                $language,
                $user
            ),
            'texts' => $this->textService->getTextsForUser(
                $language->getName(),
                $user
            ),
            'puzzles' => $this->puzzleService->getForUser($language->getName(), $user),
            'intro' => $this->introService->all(),
            'sites' => $this->languageRepository->all(),
            'currentsite' => $this->languageRepository->findOneBy(
                ['name' => config('app.lang')]
            ),
            'domain' => config('app.lang'),
        ];
    }

    public function getInfo(): array
    {
        return [
            'id' => Auth::user()->getKey(),
            'login' => Auth::user()->getLogin(),
            'avatar' => Auth::user()->getAvatar(),
            'email' => Auth::user()->getEmail(),
            'active' => Auth::user()->getActive(),
            'plan' => Auth::user()->getPlan(),
            'active_to' => Auth::user()->getActiveTo(),
        ];
    }

    public function updatePlan(User $user): void
    {
        if ($user->getActiveTo() < Carbon::now()) {
            $plan = $this->planRepository->findByName('Basic');
            $user->setPlan($plan);
        }
    }

    public function updateUserInfo(array $request): void
    {
        $user = Auth::user();

        //Requester::updateForumUser($request, $user->getEmail());

        $request['password'] = isset($request['password']) ? bcrypt(
            $request['password']
        ) : $user->getPassword();

        $this->userRepository->update($user, $request);
    }

    public function updateUser(User $user, array $data): User
    {
        $data['plan'] = $this->planRepository->get($data['plan']['id']);

        return $this->userRepository->update($user, $data);
    }

    public function delete(User $user): void
    {
        $this->userRepository->delete($user);

        event(new UserDeleted($user));
    }

    public function getOne(int $id): User
    {
        return $this->userRepository->get($id);
    }
}
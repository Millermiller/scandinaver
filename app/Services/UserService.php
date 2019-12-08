<?php

namespace App\Services;

use App\Repositories\Intro\IntroRepositoryInterface;
use Carbon\Carbon;
use App\Entities\{User, Asset};
use App\Repositories\Asset\AssetRepositoryInterface;
use App\Repositories\Language\LanguageRepositoryInterface;
use App\Repositories\Plan\PlanRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Text\TextRepositoryInterface;
use Auth;

/**
 * Class UserService
 * @package app\Services
 */
class UserService
{
    protected $user;

    /**
     * @var AssetService
     */
    protected $assetService;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var PlanRepositoryInterface
     */
    protected $planRepository;

    /**
     * @var LanguageRepositoryInterface
     */
    protected $languageRepository;

    /**
     * @var AssetRepositoryInterface
     */
    protected $assetRepository;

    /**
     * @var TextRepositoryInterface
     */
    protected $textRepository;

    /**
     * @var IntroRepositoryInterface
     */
    protected $introRepository;

    /**
     * @var
     */
    private $textService;

    /**
     * UserService constructor.
     * @param AssetRepositoryInterface $assetRepository
     * @param AssetService $assetService
     * @param UserRepositoryInterface $userRepository
     * @param PlanRepositoryInterface $planRepository
     * @param LanguageRepositoryInterface $languageRepository
     * @param TextRepositoryInterface $textRepository
     * @param IntroRepositoryInterface $introRepository
     * @param TextService $textService
     */
    public function __construct(
        AssetRepositoryInterface $assetRepository,
        AssetService $assetService,
        UserRepositoryInterface $userRepository,
        PlanRepositoryInterface $planRepository,
        LanguageRepositoryInterface $languageRepository,
        TextRepositoryInterface $textRepository,
        IntroRepositoryInterface $introRepository,
        TextService $textService
    )
    {
        $this->userRepository = $userRepository;
        $this->planRepository = $planRepository;
        $this->languageRepository = $languageRepository;
        $this->assetRepository = $assetRepository;
        $this->textRepository = $textRepository;
        $this->introRepository = $introRepository;
        $this->assetService = $assetService;
        $this->textService = $textService;
    }

    /**
     * @param  array  $data
     * @return User
     */
    public function registration(array $data)
    {
        $plan = $this->planRepository->get(1);

        /** @var \App\Entities\Language[] $languages */
        $languages = $this->languageRepository->all();

        /** @var \App\Entities\User $user */
        $user = new User();
        $user->setLogin($data['login']);
        $user->setEmail($data['email']);
        $user->setPassword(bcrypt($data['password']));
        $user->setPlan($plan);
        $user = $this->userRepository->save($user);

        foreach($languages as $language){

            //даем пользователю избранное
            $favourite = new Asset('Избранное', false, Asset::TYPE_FAVORITES, 1, $language->getId());
            $favourite = $this->assetRepository->save($favourite);
            $this->userRepository->addAsset($user, $favourite);

            //даем пользователю первый словарь слов
            $firstWordAsset = $this->assetRepository->getFirstAsset($language, Asset::TYPE_WORDS);
            $this->userRepository->addAsset($user, $firstWordAsset);

            //даем пользователю первый словарь предложений
            $firstSentencesAsset = $this->assetRepository->getFirstAsset($language, Asset::TYPE_SENTENCES);
            $this->userRepository->addAsset($user, $firstSentencesAsset);

            //даем пользователю первый текст
            $firstText = $this->textRepository->getFirstText($language);
            $this->userRepository->addText($user, $firstText);
        }

      //  event(new UserRegistered($user, $data));

      //  activity('public')->causedBy($user)->log('Зарегистрирован пользователь'); //TODO: не работает с доктриной

        return $user;
    }

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable|User $user
     * @return array
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function getState(\Illuminate\Contracts\Auth\Authenticatable $user)
    {
        $language = $this->languageRepository->get(config('app.lang'));

        return [
            'user'      => $this->getInfo(),
            'site'      => config('app.MAIN_SITE'),
            'words'     => $this->assetService->getAssetsByType($user, Asset::TYPE_WORDS),
            'sentences' => $this->assetService->getAssetsByType($user, Asset::TYPE_SENTENCES),
            'favourites'=> $this->assetRepository->getFavouriteAsset($language, $user),
            'personal'  => $this->assetRepository->getCreatedAssets($language, $user),

            'texts'       => $this->textService->getTextsForUser($user),
            'intro'       => $this->introRepository->getGrouppedIntro(),
            'sites'       => $this->languageRepository->all(),
            'currentsite' => $this->languageRepository->findOneBy(['name' => config('app.lang')]),
            'domain'      => config('app.lang'),
        ];
    }

    /**
     * @return array|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getInfo()
    {
        return [
            'id' => Auth::user()->getKey(),
            'login' => Auth::user()->getLogin(),
            'avatar' => Auth::user()->getAvatar(),
            'email' => Auth::user()->getEmail(),
            'active' => Auth::user()->getActive(),
            'plan' => Auth::user()->getPlan(),
            'active_to' => Auth::user()->getActiveTo()
        ];
    }

    public function updatePlan(User $user)
    {
        if($user->getActiveTo() < Carbon::now()){
            $plan = $this->planRepository->findByName('Basic');
            $user->setPlan($plan);
        }
    }

    /**
     * @param $request
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateUserInfo(array $request): void
    {
        $user = Auth::user();

        //Requester::updateForumUser($request, $user->getEmail());

        $request['password'] = isset($request['password']) ? bcrypt($request['password']) : $user->getPassword();

        $this->userRepository->update($user, $request);
    }
}
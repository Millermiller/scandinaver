<?php


namespace Tests\Feature\Controllers\Sub\Frontend;

use Scandinaver\Common\Domain\Language;
use Scandinaver\Learn\Domain\Asset;
use Scandinaver\Learn\Domain\Card;
use Scandinaver\Learn\Domain\Result;
use Scandinaver\User\Domain\User;
use Tests\TestCase;

/**
 * Class FavouriteControllerTest
 * @package Tests\Feature\Controllers\Sub\Frontend
 */
class FavouriteControllerTest extends TestCase
{

    /**
     * @var User
     */
    private $user;

    /**
     * @var Asset
     */
    private $asset;

    /**
     * @var Asset
     */
    private $favouriteAsset;

    /**
     * @var Card
     */
    private $card;

    /**
     * @var Card
     */
    private $favouriteCard;

    public function setUp()
    {
        parent::setUp();

        /** @var Language $language */
        $language = entity(Language::class)->create();

        $this->user           = entity(User::class)->create();
        $this->asset          = entity(Asset::class)->create(['user' => $this->user, 'language' => $language]);
        $this->favouriteAsset = entity(Asset::class)->create(['user' => $this->user, 'language' => $language, 'favorite' => 1]);

        entity(Result::class)->create(['user' => $this->user, 'language' => $language, 'asset' => $this->asset]);
        entity(Result::class)->create(['user' => $this->user, 'language' => $language, 'asset' =>  $this->favouriteAsset]);

        $this->card = entity(Card::class)->create(['language' => $language, 'asset' => $this->asset ]);
        $this->favouriteCard = entity(Card::class)->create(['language' => $language, 'asset' => $this->favouriteAsset ]);
    }

    public function testStore()
    {
        $this->actingAs($this->user, 'api');

        $response = $this->post(
            route(
                'sub_frontend::add-favorite',
                ['domain' => 'is', 'word' => 1, 'translate' => 1]
            )
        );

        $this->assertEquals(201, $response->getStatusCode());

        // $response->assertJsonStructure(
        //     [
        //         'id',
        //         'asset_id',
        //         'word_id',
        //         'translate_id',
        //         'id',
        //         'favourite',
        //         'word' => [],
        //         'translate' => [],
        //         'asset' => [],
        //     ]
        // );

        // $data = $response->decodeResponseJson();

        // $this->assertEquals(1, $data['word']['id']);
        // $this->assertEquals(1, $data['translate']['id']);
        // $this->assertEquals(5, $data['asset']['id']);
    }

    public function testDestroy()
    {
        $this->actingAs($this->user, 'api');

        $response = $this->delete(route('sub_frontend::delete-favorite', ['domain' => 'is', 'id' => $this->favouriteCard->getWord()->getId()]));

        $this->assertEquals(204, $response->getStatusCode());
    }
}
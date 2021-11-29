<?php


namespace App\Http\Controllers;

/**
 * Class IndexController
 *
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{

    public function index()
    {
        echo 'v. ' . json_decode(file_get_contents(base_path('/composer.json')))->version;
        echo '<br>';
        echo "PHP_VERSION: ".PHP_VERSION;
    }
}
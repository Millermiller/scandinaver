<?php


namespace Scandinaver\Learn\Domain\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Scandinaver\Common\Domain\Model\Language;
use Scandinaver\Learn\Domain\Contract\AudioParserInterface;
use Scandinaver\Learn\Domain\Contract\Repository\WordRepositoryInterface;
use Scandinaver\Learn\Domain\Exceptions\AudioFileCantParsedException;
use Scandinaver\Learn\Domain\Model\Word;

/**
 * Class AudioService
 *
 * @package Scandinaver\Learn\Domain\Services
 */
class AudioService
{
    private WordRepositoryInterface $wordsRepository;

    private AudioParserInterface $parser;

    public function __construct(
        WordRepositoryInterface $wordsRepository,
        AudioParserInterface $parser
    ) {
        $this->wordsRepository = $wordsRepository;
        $this->parser = $parser;
    }

    public function count(): int
    {
        return $this->wordsRepository->countAudio();
    }

    public function countByLanguage(Language $language): int
    {
        return $this->wordsRepository->getCountAudioByLanguage($language);
    }

    public function upload(Word $word, UploadedFile $file): Word
    {
        $path = $file->store('audio');

        $word->setAudio($path);

        $this->wordsRepository->save($word);

        return $word;
    }

    /**
     * TODO: use laravel curl wrapper and Storage
     *
     * @param  Word  $word
     *
     * @return string
     */
    public function parse(Word $word): string
    {
        try {
            $link = $this->parser->parse($word->getWord());

            $curl = curl_init();
            curl_setopt(
                $curl,
                CURLOPT_URL,
                'https://forvo.com/player-mp3Handler.php?path='.$link
            );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            //curl_setopt($curl, CURLOPT_COOKIEFILE, BASE_URL . '/temp/cookie.txt');
            $file = curl_exec($curl);
            curl_close($curl);

            $filename = Str::random(32);

            touch(public_path().'/audio/'.$filename.'.mp3');
            $fp = fopen(public_path().'/audio/'.$filename.'.mp3', 'w');
            $filesize = fwrite($fp, $file);
            fclose($fp);

            if ($filesize > 0) {
                $word->setAudio('/audio/'.$filename.'.mp3');
                $this->wordsRepository->save($word);
            }

        } catch (AudioFileCantParsedException $e) {
            //
        }

        return $word;
    }
}
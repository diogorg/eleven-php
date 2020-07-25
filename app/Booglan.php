<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Booglan extends Model
{
    protected $fillable = [
        'id',
        'text'
    ];

    /**
     * Array about Foo letters
     *
     * @var array
     */
    private $_foo = ['r', 't', 'c', 'd', 'b'];
    /**
     * Booglan alphabet order
     *
     * @var array
     */
    private $_ordering = [
        't', 'w', 'h',
        'z', 'k', 'd',
        'f', 'v', 'c',
        'j', 'x', 'l',
        'r', 'n', 'q',
        'm', 'g', 'p',
        's', 'b'
        ];
    /**
     * Normal alphabet order
     *
     * @var array
     */
    private $_alphabet = [
        'a', 'b', 'c',
        'd', 'e', 'f',
        'g', 'h', 'i',
        'j', 'k', 'l',
        'm', 'n', 'o',
        'p', 'q', 'r',
        's', 't'
        ];

    public function firstQuestion(): ?int
    {
        $prepositions = 0;
        $words = explode(' ', $this->text);
        foreach ($words as $word) {
            $cleanWord = trim($word);
            if ($this->isPreposition($cleanWord)) {
                $prepositions++;
            }
        }
        return $prepositions;
    }

    private function isPreposition(String $word): bool
    {
        $prepositionsSize = 5;
        return strlen($word) === $prepositionsSize &&
            !in_array(substr($word, -1), $this->_foo) &&
            strpos($word, 'l') === false;
    }

    private function verbs(): array
    {
        $verbs = 0;
        $firstPerson = 0;
        $words = explode(' ', $this->text);
        foreach ($words as $word) {
            $cleanWord = trim($word);
            if ($this->isVerb($cleanWord)) {
                $verbs++;
                if ($this->isFirstPersonVerb($cleanWord)) {
                    $firstPerson++;
                }
            }
        }
        return ['verbs' => $verbs, 'firstPerson' => $firstPerson];
    }

    private function isVerb(String $word): bool
    {
        $verbMinSize = 8;
        return strlen($word) >= $verbMinSize &&
            !in_array(substr($word, -1), $this->_foo);
    }

    private function isFirstPersonVerb(String $word): bool
    {
        return !in_array(substr($word, 0, 1), $this->_foo);
    }

    public function secondQuestion(): ?int
    {
        $verbs = $this->verbs();
        return $verbs['verbs'];
    }

    public function thirdQuestion(): ?int
    {
        $verbs = $this->verbs();
        return $verbs['firstPerson'];
    }

    public function fourthQuestion(): ?array
    {
        $vocabulary = [];
        $cleanText = preg_replace("/\r|\n/", "", $this->text);
        $words = array_filter(explode(' ', $cleanText));
        $vocabulary = array_unique($words);
        return $this->sortVocabulary($vocabulary);
    }

    private function sortVocabulary(?array $vocabulary): ?array
    {
        $translated = $this->arrayTranslate(
            $this->_ordering,
            $this->_alphabet,
            $vocabulary
        );
        asort($translated);
        $vocabulary = $this->arrayTranslate(
            $this->_alphabet,
            $this->_ordering,
            $translated
        );
        return array_values($vocabulary);
    }

    private function arrayTranslate(
        array $search,
        array $replace,
        ?array $vocabulary
    ): ?array {
        $newVocabulary = [];
        foreach ($vocabulary as $word) {
            $newVocabulary[] = $this->alphabetTranslate($search, $replace, $word);
        }
        return $newVocabulary;
    }

    private function alphabetTranslate(
        array $search,
        array $replace,
        String $subject
    ): string {
        return strtr($subject, array_combine($search, $replace));
    }

    public function fifthQuestion(): int
    {
        $beautifulWords = 0;
        $words = explode(' ', $this->text);
        foreach ($words as $word) {
            $cleanWord = trim($word);
            $value = $this->calculateValue($cleanWord);
            if ($this->isBeautifulWord($value)) {
                $beautifulWords++;
            }
        }
        return $beautifulWords;
    }

    private function isBeautifulWord(int $value): bool
    {
        $beautifulMinSize = 422224;
        $beautifulDivisible = 3;
        return $value >= $beautifulMinSize && $value % $beautifulDivisible === 0;
    }

    private function calculateValue(String $str): int
    {
        $numericBase = 20;
        $count = 0;
        $chars = str_split($str);
        foreach ($chars as $position => $char) {
            $exp = pow($numericBase, $position);
            $value = array_search($char, $this->_ordering) * $exp;
            $count += $value;
        }
        return $count;
    }
}

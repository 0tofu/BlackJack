<?php

namespace UnitTest;

use BlackJack\Card;
use BlackJack\Deck;
use BlackJack\Player;
use PHPUnit\Framework\TestCase;
use UnitTest\Common\Utils;

/**
 * Playerクラスのテスト.
 *
 * @package UnitTest
 */
class PlayerTest extends TestCase {

  /**
   * コンストラクタのテスト.
   */
  public function testConstruct() {
    $deck = new Deck();
    $player = new Player('プレーヤー', $deck);

    $player_name = Utils::getPropertyValue($player, 'name');
    $this->assertEquals('プレーヤー', $player_name);

    $player_deck = Utils::getPropertyValue($player, 'deck');
    $this->assertEquals($deck, $player_deck);
  }

  /**
   * getNameのテスト.
   */
  public function testGetName() {
    $deck = new Deck();
    $player = new Player('プレーヤー', $deck);

    $this->assertEquals('プレーヤー', $player->getName());
  }

  /**
   * getCardsScoreのテスト.
   *
   * @dataProvider  provideGetCardsScore
   */
  public function testGetCardsScore($expected, $cards) {
    $deck = new Deck();
    $player = new Player('プレーヤー', $deck);

    Utils::setPropertyValue($player, 'cards', $cards);

    $this->assertEquals($expected, $player->getCardsScore());
  }

  /**
   * getCardsScoreを検証する為のテストデータ生成.
   *
   * @return array
   */
  public static function provideGetCardsScore() {
    $score_and_cards = [
      ['score' => 11, 'cards' => [1]],
      ['score' => 2, 'cards' => [2]],
      ['score' => 10, 'cards' => [10]],
      ['score' => 10, 'cards' => [11]],
      ['score' => 12, 'cards' => [1, 1]],
      ['score' => 9, 'cards' => [2, 7]],
      ['score' => 20, 'cards' => [10, 11]],
      ['score' => 21, 'cards' => [1, 13]],
      ['score' => 13, 'cards' => [1, 1, 1]],
      ['score' => 12, 'cards' => [1, 10, 1]],
      ['score' => 30, 'cards' => [11, 12, 13]],
    ];

    $score_and_cards = array_map(function ($score_and_card) {
      $cards = [];
      foreach ($score_and_card['cards'] as $card) {
        $cards[] = new Card('ハート', $card);
      }
      return [$score_and_card['score'], $cards];
    }, $score_and_cards);

    return $score_and_cards;
  }

}

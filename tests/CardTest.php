<?php

namespace UnitTest;

use BlackJack\Card;
use BlackJack\Deck;
use PHPUnit\Framework\TestCase;
use UnitTest\Common\Utils;

/**
 * カードクラスのテスト.
 */
class CardTest extends TestCase {

  /**
   * コンストラクタのテスト.
   *
   * @dataProvider provideDefaultCards
   *
   * @throws \ReflectionException
   */
  public function testConstruct($mark, $no) {
    $card = new Card($mark, $no);

    $this->assertEquals($mark, Utils::getPropertyValue($card, 'mark'));
    $this->assertEquals($no, Utils::getPropertyValue($card, 'no'));
  }

  /**
   * getNo関数のテスト.
   *
   * @dataProvider provideDefaultCards
   */
  public function testGetNo($mark, $no) {
    $card = new Card($mark, $no);

    $this->assertEquals($no, $card->getNo());
  }

  /**
   * getDisplayNameのテスト.
   *
   * @dataProvider provideDisplayName
   */
  public function testGetDisplayName($mark, $no, $expected) {
    $card = new Card($mark, $no);

    $this->assertEquals($expected, $card->getDisplayName());
  }

  /**
   * getPointのテスト.
   *
   * @dataProvider providePoint
   */
  public function testGetPoint($mark, $no, $expected) {
    $card = new Card($mark, $no);

    $this->assertEquals($expected, $card->getPoint());
  }

  /**
   * デフォルトのカード配列を生成するデータプロバイダ.
   *
   * @return array
   *   カード配列.
   */
  public static function provideDefaultCards() {
    $cards = [];

    foreach (Deck::MARKS as $mark) {
      foreach (range(1, 13) as $num) {
        $cards[] = [$mark, $num];
      }
    }

    return $cards;
  }

  /**
   * カード配列に表示用の情報を加えた配列を生成するデータプロバイダ.
   *
   * @return array
   *   カード配列.
   */
  public static function provideDisplayName() {
    $conversion = [
      1 => 'A',
      11 => 'J',
      12 => 'Q',
      13 => 'K',
    ];

    $cards = [];
    foreach (self::provideDefaultCards() as $card) {
      $display = $card[1];
      if (array_key_exists($display, $conversion)) {
        $display = $conversion[$display];
      }
      $card[] = $card[0] . 'の' . $display;
      $cards[] = $card;
    }

    return $cards;
  }

  /**
   * カード配列にポイント情報を加えた配列を生成するデータプロバイダ.
   *
   * @return array
   *   カード配列.
   */
  public static function providePoint() {
    $cards = [];
    foreach (self::provideDefaultCards() as $card) {
      $point = ($card[1] > 10) ? 10 : $card[1];
      $card[] = $point;
      $cards[] = $card;
    }

    return $cards;
  }

}
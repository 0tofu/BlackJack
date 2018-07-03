<?php

namespace UnitTest;

use BlackJack\Deck;
use PHPUnit\Framework\TestCase;
use UnitTest\Common\Utils;

/**
 * Deckクラスのテスト.
 *
 * @package UnitTest
 */
class DeckTest extends TestCase {

  /**
   * コンストラクタのテスト.
   *
   * @throws \ReflectionException
   */
  public function testConstruct() {
    $deck = new Deck();

    $trumps = Utils::getPropertyValue($deck, 'trumps');
    // コンストラクタで生成したトランプが52枚であること.
    $this->assertCount(52, $trumps);
    // すべてカードクラスであること.
    $this->assertContainsOnly('BlackJack\Card', $trumps);

    // 絵柄/番号をセットにした配列を生成.
    $cards = [];
    foreach (Deck::MARKS as $mark) {
      foreach (range(1, 13) as $num) {
        $cards["{$mark}{$num}"] = TRUE;
      }
    }

    // ↑で生成した通りのカードが存在すること.
    foreach ($trumps as $trump) {
      $mark = Utils::getPropertyValue($trump, 'mark');
      $no = $trump->getNo();
      $card = "{$mark}{$no}";
      $this->assertArrayHasKey($card, $cards);
      unset($cards[$card]);
    }

    // 生成したカードに漏れがないこと.
    $this->assertCount(0, $cards);
  }

  /**
   * drawのテスト.
   *
   * @throws \ReflectionException
   */
  public function testDraw() {
    $deck = new Deck();

    // 引いたカードが配列の先頭と同一であること.
    $trumps = Utils::getPropertyValue($deck, 'trumps');
    $expected = $trumps[0];
    $card = $deck->draw();
    $this->assertEquals($expected, $card);

    // 引いた後の要素数が51であること.
    $trumps = Utils::getPropertyValue($deck, 'trumps');
    $this->assertCount(51, $trumps);
  }

}
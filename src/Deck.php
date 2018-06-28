<?php

namespace BlackJack;

require_once dirname(__FILE__) . '/Card.php';

/**
 * トランプの情報を保持するクラス.
 */
class Deck {
  const MARKS = ['ハート', 'スペード', 'ダイヤ', 'クラブ'];

  static private $trumps = [];

  /**
   * コンストラクタ.
   */
  public function __construct() {
    // 全52枚のトランプを生成.
    foreach (self::MARKS as $mark) {
      foreach (range(1, 13) as $num) {
        self::$trumps[] = new Card($mark, $num);
      }
    }
    // トランプの並び替え.
    shuffle(self::$trumps);
  }

  /**
   * カードを1枚引くメソッド.
   *
   * @return Card
   *   引いたカード.
   */
  public function draw() {
    return array_shift(self::$trumps);
  }

}

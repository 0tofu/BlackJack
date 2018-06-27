<?php

namespace BlackJack;

/**
 * Playerクラスの定義.
 */
class Player {
  const MARKS = ['ハート', 'スペード', 'ダイヤ', 'クラブ'];

  static private $trump = [];

  private $cards = [];

  /**
   * コンストラクタ.
   */
  public function __construct() {
    // トランプが未定義の場合、トランプを生成.
    if (empty(Player::$trump)) {
      foreach (self::MARKS as $mark) {
        foreach (range(1, 13) as $num) {
          if ($num > 10) {
            $num = 10;
          }
          Player::$trump[$mark][] = $num;
        }
      }
    }
  }

  /**
   * カードを引くメソッド.
   *
   * @return array
   *   引いたカード.
   */
  public function choiseCard() {

    $mark = self::MARKS[rand(0, count(self::MARKS) - 1)];
    $num = rand(0, count(Player::$trump[$mark]) - 1);

    $card = [
      'mark' => $mark,
      'num' => Player::$trump[$mark][$num],
    ];
    array_splice(Player::$trump[$mark], $num, 1);

    $this->cards[] = $card;
    return $card;
  }

  /**
   * 引数で指定したnum枚目のカードを返す.
   *
   * @param int $num
   *   num枚目のカード.
   *
   * @return array
   *   カード.
   */
  public function getSelectedCard($num) {
    $num--;
    return $this->cards[$num];
  }

  /**
   * 手持ちのカードの合計点数を返す.
   *
   * @return int
   *   合計点数.
   */
  public function getCardsSum() {
    if (count($this->cards) === 0) {
      return 0;
    }

    return array_reduce($this->cards, function($sum, $card) {
      $sum += $card['num'];
      return $sum;
    });
  }

}

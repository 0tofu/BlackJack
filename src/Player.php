<?php

namespace BlackJack;

/**
 * Playerクラスの定義.
 */
class Player {

  /**
   * 山札.
   *
   * @var Deck
   */
  private $deck;

  /**
   * 保持しているカード.
   *
   * @var Card[]
   */
  private $cards = [];

  /**
   * コンストラクタ.
   *
   * @param Deck $deck
   *   山札.
   */
  public function __construct(Deck $deck) {
    $this->deck = $deck;
  }

  /**
   * カードを引く.
   *
   * @return string
   *   引いたカード.
   */
  public function choiseCard() {
    $card = $this->deck->choiceCard();
    $this->cards[] = $card;

    return $card->getMark() . 'の' . $card->getDisplayName();
  }

  /**
   * 21を超えたか判定する.
   *
   * @return bool
   *   判定結果.
   */
  public function isBurst() {
    return $this->getCardsSum() > 21;
  }

  /**
   * 引数で指定したnum枚目のカードを返す.
   *
   * @param int $num
   *   num枚目のカード.
   *
   * @return string
   *   カード.
   */
  public function getSelectedCard($num) {
    $num--;
    $card = $this->cards[$num];

    return $card->getMark() . 'の' . $card->getDisplayName();
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

    return array_reduce($this->cards, function ($sum, $card) {
      $sum += $card->getPoint();
      return $sum;
    });
  }

}

<?php

namespace BlackJack;

/**
 * Playerクラスの定義.
 */
class Player {

  /**
   * プレイヤーの名前.
   *
   * @var string
   */
  private $name;

  /**
   * 利用する山札.
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
   * @param string $name
   *   プレイヤー名.
   * @param Deck $deck
   *   山札.
   */
  public function __construct($name, Deck $deck) {
    $this->name = $name;
    $this->deck = $deck;
  }

  /**
   * プレイヤー名を返す.
   */
  public function getName() {
    return $this->name;
  }

  /**
   * カードを引く.
   *
   * @param bool $hide
   *   引いたカードの内容を隠すかどうか.
   *
   * @return string
   *   引いたカード.
   */
  public function choiseCard($hide = FALSE) {
    $card = $this->deck->draw();
    $this->cards[] = $card;

    $message = "{$this->name}の引いたカードは{$card->getDisplayName()}です\n";
    if ($hide) {
      $card_num = count($this->cards);
      $message = "{$this->name}の{$card_num}枚目のカードは分かりません。\n";
    }

    return $message;
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
    $card = $this->cards[$num - 1];

    return "{$this->name}の{$num}枚目のカードは{$card->getDisplayName()}です\n";
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

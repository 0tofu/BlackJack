<?php

namespace BlackJack;

/**
 * Playerクラスの定義.
 */
class Player {

  const BLACK_JACK = 21;

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

    $message = "{$this->name}の引いたカードは{$card->getDisplayName()}です";
    if ($hide) {
      $card_num = count($this->cards);
      $message = "{$this->name}の{$card_num}枚目のカードは分かりません。";
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
    return $this->getCardsScore() > self::BLACK_JACK;
  }

  /**
   * 引数で指定したnum枚目のカードを返す.
   *
   * @param int $num
   *   num枚目のカード.
   * @param bool $show_player_name
   *   名前を表示するかどうか.
   * 
   * @return string
   *   カード.
   */
  public function getSelectedCard($num, $show_player_name = TRUE) {
    $card = $this->cards[$num - 1];

    $message = $show_player_name ? "{$this->name}の" : "";
    $message .= "{$num}枚目のカードは{$card->getDisplayName()}です";
    return $message;
  }

  /**
   * 手持ちのカードの合計点数を返す.
   *
   * @return int
   *   合計点数.
   */
  public function getCardsScore() {
    if (count($this->cards) === 0) {
      return 0;
    }

    // 保有するカードのスコアを算出.
    $score = array_reduce($this->cards, function ($score, $card) {
      $score += $card->getPoint();
      return $score;
    });

    // Aを保持する場合のスコアを算出し、21以下であれば置き換え.
    $temp_score = $score + 10;
    if ($this->haveAce() && $temp_score <= self::BLACK_JACK) {
      $score = $temp_score;
    }

    return $score;
  }

  /**
   * 手持ちの全てのカードを表示する為の関数.
   */
  public function printAllCards() {
    $message = [];
    foreach ($this->cards as $num => $card) {
      $message[] = $this->getSelectedCard($num + 1, FALSE);
    }

    return implode("\n", $message);
  }

  /**
   * 現在のスコアを画面に表示する為の関数.
   */
  public function printCardScore() {
    $score = $this->getCardsScore();

    return "{$this->getName()}の得点は<red>{$score}<reset>です";
  }

  /**
   * 引数で指定した相手との勝敗を返す.
   *
   * @param Player $opponent
   *   対戦相手.
   *
   * @return string
   *   勝敗結果.
   */
  public function printVictoryOrDefeat(Player $opponent) {
    $self_score = $this->getCardsScore();
    $opponent_score = $opponent->getCardsScore();

    $message = '引き分けです。';
    // 自身がバーストしていれば、相手の勝ち.
    // 相手がバーストせず、相手の得点が高ければ相手の勝ち.
    if ($this->isBurst() || (!$opponent->isBurst() && $opponent_score > $self_score)) {
      $message = $opponent->getName() . 'の勝ちです。';
    }
    // 相手がバーストまたは自分の得点が高ければ自分の勝ち.
    elseif ($opponent->isBurst() || $self_score > $opponent_score) {
      $message = $this->getName() . 'の勝ちです。';
    }

    return $message;
  }

  /**
   * 手持ちのカードにエースが含まれるか検証.
   *
   * @return bool
   *   結果.
   */
  private function haveAce() {
    return (bool) array_filter($this->cards, function ($card) {
      return $card->getNo() === 1;
    });
  }

}

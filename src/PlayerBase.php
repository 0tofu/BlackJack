<?php

namespace BlackJack;

require_once dirname(__FILE__) . '/PlayerBaseInterface.php';

/**
 * Playerクラスの定義.
 */
abstract class PlayerBase implements PlayerBaseInterface {

  const BLACK_JACK = 21;

  /**
   * プレイヤーの名前.
   *
   * @var string
   */
  protected $name;

  /**
   * 利用する山札.
   *
   * @var Deck
   */
  protected $deck;

  /**
   * 保持しているカード.
   *
   * @var Card[]
   */
  protected $cards = [];

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
  public function isBust() {
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
    // そもそも手持ちカードが無い場合、0.
    if (count($this->cards) === 0) {
      return 0;
    }

    // 今の手持ちカードの合計を算出.
    // Aを1or11として考える為、各パターンでの合計を配列化し
    // その中の21を超えない最大値を返す.
    $scores = [];
    foreach ($this->cards as $card) {
      // 2枚目以降の合計を数える際は全ての配列に合計を追加.
      if (count($scores) != 0) {
        foreach ($scores as $idx => $score) {
          $scores[$idx] = $score + $card->getPoint();
        }
      }
      else {
        $scores[] = $card->getPoint();
      }

      // 該当カードがAの時は各合計に+10(A=11とした場合)の合計を算出.
      if ($card->getNo() == '1') {
        $temp_scores = $scores;
        foreach ($temp_scores as $score) {
          $scores[] = $score + 10;
        }
      }
    }

    // 21を超えるもの、超えないものに分割.
    $non_bust_scores = [];
    $bust_scores = [];
    foreach ($scores as $score) {
      if ($score <= self::BLACK_JACK) {
        $non_bust_scores[] = $score;
      }
      else {
        $bust_scores[] = $score;
      }
    }

    // 21以下の最大値 or 全てバーストした場合、バーストした中の最小値(21に近い数字)を返す.
    return count($non_bust_scores) ? max($non_bust_scores) : min($bust_scores);
  }

  /**
   * 手持ちの全てのカードと合計得点を表示する為の関数.
   */
  public function printAllCardsAndScore() {
    $message = [];

    $message[] = "========== {$this->getName()} の全カード ==========";

    foreach ($this->cards as $num => $card) {
      $message[] = $this->getSelectedCard($num + 1, FALSE);
    }

    $message[] = "========== {$this->getName()} の得点 ==========";
    $message[] = $this->printCardScore();

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
   * @param PlayerBase $opponent
   *   対戦相手.
   *
   * @return string
   *   勝敗結果.
   */
  public function printVictoryOrDefeat(PlayerBase $opponent) {
    $self_score = $this->getCardsScore();
    $opponent_score = $opponent->getCardsScore();

    $message = '引き分けです。';
    // 自身がバーストしていれば、相手の勝ち.
    // 相手がバーストせず、相手の得点が高ければ相手の勝ち.
    if ($this->isBust() || (!$opponent->isBust() && $opponent_score > $self_score)) {
      $message = $opponent->getName() . 'の勝ちです。';
    }
    // 相手がバーストまたは自分の得点が高ければ自分の勝ち.
    elseif ($opponent->isBust() || $self_score > $opponent_score) {
      $message = $this->getName() . 'の勝ちです。';
    }

    return $message;
  }

}

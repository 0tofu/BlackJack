<?php

namespace BlackJack;

/**
 * カード1枚を表すクラス.
 */
class Card {

  /**
   * 記号.
   *
   * @var string
   */
  private $mark;

  /**
   * 番号.
   *
   * @var int
   */
  private $no;

  /**
   * コンストラクタ.
   *
   * @param string $mark
   *   記号.
   * @param int $no
   *   番号.
   */
  public function __construct($mark, $no) {
    $this->mark = $mark;
    $this->no = $no;
  }

  /**
   * カードの番号を返す.
   *
   * @return int
   *   番号.
   */
  public function getNo() {
    return $this->no;
  }

  /**
   * 表示用カード情報(記号+番号)を返す.
   *
   * @return string
   *   表示用番号.
   */
  public function getDisplayName() {
    $conversion_table = [
      1 => 'A',
      11 => 'J',
      12 => 'Q',
      13 => 'K',
    ];

    $display_num = $this->no;
    if (array_key_exists($display_num, $conversion_table)) {
      $display_num = $conversion_table[$display_num];
    }

    return $this->mark . 'の' . $display_num;
  }

  /**
   * カードの得点を返す.
   *
   * @return int
   *   得点.
   */
  public function getPoint() {
    return ($this->no > 10) ? 10 : $this->no;
  }

}

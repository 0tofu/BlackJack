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
   * カードの記号を返す.
   *
   * @return string
   */
  public function getMark() {
    return $this->mark;
  }

  /**
   * カードの番号を返す.
   *
   * @return int
   */
  public function getNo() {
    return $this->no;
  }

  /**
   * カードの表示用番号を返す.
   *
   * @return string
   */
  public function getDisplayName() {
    $conversion_table = [
      1 => 'A',
      11 => 'J',
      12 => 'Q',
      13 => 'K'
    ];

    $display_name = $this->no;
    if (array_key_exists($display_name, $conversion_table)) {
      $display_name = $conversion_table[$display_name];
    }

    return (string) $display_name;
  }

  /**
   * カードの得点を返す.
   *
   * @return int
   */
  public function getPoint() {
    return ($this->no > 10) ? 10 : $this->no;
  }

}

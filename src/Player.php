<?php

namespace BlackJack;

require_once dirname(__FILE__) . '/PlayerBase.php';
require_once dirname(__FILE__) . '/Utils.php';

/**
 * Class Player.
 *
 * @package BlackJack
 */
class Player extends PlayerBase {

  /**
   * {@inheritdoc}
   */
  public function initializeCard() {
    for ($i = 0; $i < 2; $i++) {
      Utils::puts("<cyan>{$this->choiseCard()}");
    }
  }

  /**
   * {@inheritdoc}
   */
  public function confirmCard() {
    // プレイヤーの入力に基づきカードを引く.
    do {
      Utils::puts($this->printCardScore());
      if ($this->isBust()) {
        break;
      }
      Utils::puts('カードを引きますか？引く場合は<cyan>Y<reset>を、引かない場合は<cyan>N<reset>を入力してください。');

      $stdin = mb_strtolower(trim(fgets(STDIN)));
      switch ($stdin) {
        case 'y':
          Utils::puts("<cyan>{$this->choiseCard()}");
          break;

        case 'n':
          break;

        default:
          Utils::puts("<red>'Y' または 'N' を入力してください。");
      }
    } while ($stdin != 'n');
  }

}

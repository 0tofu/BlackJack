<?php

namespace BlackJack;

require_once dirname(__FILE__) . '/PlayerBase.php';
require_once dirname(__FILE__) . '/Utils.php';

/**
 * Class Dealer.
 *
 * @package BlackJack
 */
class Dealer extends PlayerBase {

  /**
   * {@inheritdoc}
   */
  public function giveOutCards() {
    for ($i = 0; $i < 2; $i++) {
      Utils::puts("<purple>{$this->choiseCard($i == 1)}");
    }
  }

  /**
   * {@inheritdoc}
   */
  public function nextCard() {
    // ディーラーが2枚目に引いたカード情報及び得点を表示.
    Utils::puts("<purple>{$this->getSelectedCard(2)}");
    Utils::puts($this->printCardScore());

    // ディーラーのカードを引く.
    while ($this->getCardsScore() < 17) {
      Utils::puts("<purple>{$this->choiseCard()}");
    }
  }

}

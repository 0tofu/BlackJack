<?php

namespace BlackJack;

/**
 * Interface PlayerBaseInterface.
 *
 * @package BlackJack
 */
interface PlayerBaseInterface {

  /**
   * 初回のカードを引く処理.
   */
  public function initializeCard();

  /**
   * 初回以降のカードを引く処理.
   */
  public function confirmCard();

}

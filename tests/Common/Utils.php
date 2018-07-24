<?php

namespace UnitTest\Common;

use ReflectionClass;

/**
 * ユーティリティクラス.
 *
 * @package UnitTest\Common
 */
class Utils {

  /**
   * プライベートなプロパティの値を返す.
   *
   * @param Object $obj
   *   任意のオブジェクト.
   * @param string $name
   *   プロパティ名.
   *
   * @return mixed
   *   取得した値.
   *
   * @throws \ReflectionException
   */
  public static function getPropertyValue($obj, $name) {
    $reflection_class = new ReflectionClass(get_class($obj));
    $property = $reflection_class->getProperty($name);
    $property->setAccessible(TRUE);
    return $property->getValue($obj);
  }

  /**
   * プライベートなプロパティの値をセットする.
   *
   * @param Object $obj
   *   任意のオブジェクト.
   * @param string $name
   *   プロパティ名.
   * @param $value
   *   セットする値.
   *
   * @throws \ReflectionException
   */
  public static function setPropertyValue($obj, $name, $value) {
    $reflection_class = new ReflectionClass(get_class($obj));
    $property = $reflection_class->getProperty($name);
    $property->setAccessible(TRUE);
    $property->setValue($obj, $value);
  }

}

<?php
/**
 * EMongoCacheDependency
 *
 * @uses CCacheDependency
 * @package
 * @version $id$
 * @copyright 1997-2005 The PHP Group
 * @author Tobias Schlitt <toby@php.net>
 * @license PHP Version 3.0 {@link http://www.php.net/license/3_0.txt}
 */
class EMongoCacheDependency extends CCacheDependency
{

  /**
   * crit
   *
   * @var EMongoCriteria
   * @access private
   */
  private $crit;
  /**
   * collection
   *
   * @var EMongoDocument
   * @access private
   */
  private $collection;

  public function __construct(EMongoDocument $collection, EMongoCriteria $criteria)
  {
    $this->collection = $collection;
    $this->crit = $criteria;
    $this->crit->limit(1);
  }

  /**
   * generateDependentData
   *
   * @access protected
   * @return void
   */
  protected function generateDependentData()
  {
    $res = $this->collection->find($this->crit);
    if (! $res instanceof $this->collection) {
      return null;
    }
    return md5(serialize($res->toArray()));
  }
}
